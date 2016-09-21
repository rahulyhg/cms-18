<?php
namespace frontend\modules\invoice\controllers;
use Yii;

use common\components\BaseController;
use common\models\User;
use common\models\Customer;
use yii\web\Controller;
use common\models\Company;
use common\models\CustomerInvoices;
use kartik\mpdf\Pdf;
use common\services\EmailService;
use yii\helpers\BaseFileHelper;
use yii\base\ErrorException;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use common\components\CommonUtils;
/**
 * Customers Controller
 */
 class DefaultController extends BaseController
 {
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    /*
     *  function default for controller
     */
    public function actionIndex($customer_id=null)
    {
        if(Yii::$app->session['report_invoice']) {
            unset(Yii::$app->session['report_invoice']);
        }
        $owner = null; 
        $model = new CustomerInvoices();
        if(empty($customer_id)) {
            $owner = Yii::$app->user->identity->getOwnerId();
        }
        $data = Yii::$app->request->get();
        if(Yii::$app->request->isGet) {
            $model->load($data);
        }
        
        $deleted = Yii::$app->request->get('deleted');
        
        if(empty($customer_id)) {
            Yii::$app->session['Customer_id'] = Null;
            $dataProvider = $model->search($data,$owner,NULL,$deleted);
        }
        else
        {
             $owner = Yii::$app->user->identity->getOwnerId();
             $customer = Customer::findOne($customer_id);
             if( $owner  != $customer->user_id) {
                 throw new NotFoundHttpException('The requested page does not exist.');
             }
             if(!isset($customer->id)) {
                 throw new NotFoundHttpException('The requested page does not exist.');
             }
             Yii::$app->session['Customer_id'] = $customer_id;
             $dataProvider = $model->search($data,$owner,$customer_id,$deleted);
        }
        #render view
        if(isset($customer_id) && !empty($customer_id))
        {
            $customer= \common\models\Customer::findOne($customer_id);
            $this->view->params['breadcrumbs'][] = ['label' => 'Customer', 'url' => ['/customer']];
            $this->view->params['breadcrumbs'][] = ['label' => $customer->name, 'url' => ['/customer/default/view?id='.$customer->id]];
            $this->view->params['breadcrumbs'][] = ['label' => 'Invoices'];
        }
        else
        {
             $this->view->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Invoices')];
        }
        
        return $this->render('@common/views/invoice/index.phtml',
                                [  
                                    'model' => $model,
                                    'dataProvider' =>$dataProvider,
                                    'customer_id' => $customer_id
                                ]);
    }

    /**
     * Displays a single Customer model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        $invoiceItem = \common\models\CustomerInvoiceItems::find()->where(['invoice_id'=>$model->id])->all();
        
        $job = \common\models\Jobs::findOne($model->job_id);
        
        $customer = Customer::findOne($model->customer_id);
        
        $car = $job->car;
        
        $this->view->registerCssFile('/public/tpl/admin/pages/css/invoice.css');
        $this->view->registerCssFile('/public/css/status-view-invoice.css');  
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Invoice'), 'url' => ['/report/invoice']];
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('app', '#'.$model->invoice_number)];
        return $this->render('@common/views/invoice/view.phtml',
                                [  
                                    'model' => $model,
                                    'invoiceItem' => $invoiceItem,
                                    'customer' => $customer,
                                    'job' => $job,
                                    'car' => $car,
                                ]);
    }

     /**
      * Creates a new Customer model.
      * If creation is successful, the browser will be redirected to the 'view' page.
      * @return mixed
      */
     public function actionCreate($customer_id = null)
     {
        throw new NotFoundHttpException('The requested page does not exist.');
        Yii::$app->end();
        $model = new CustomerInvoices();
        $model->total_received ='0.00';
        $model->subtotal ='0.00';
        $model->total='0.00';
        $model->amount_due = '0.00';
        $user = User::findOne(Yii::$app->user->getId());
        if(!empty($customer_id)) {
             $customer = Customer::findOne($customer_id);
             $user = User::findOne($customer->user_id);
        }
        $owner_id = $user->getOwnerId();
        $invoiceNumber = \common\models\UserSettings::getInvoiceNumber($owner_id);
        $model->invoice_number = $invoiceNumber->options;
        $model->owner_id = $owner_id;
        $invoiceItem[0] = new \common\models\CustomerInvoiceItems();
        $data = Yii::$app->request->Post();
        $saveData = false;
       
        if(Yii::$app->request->isPost) {
           
            $dataInvoice = isset($data['CustomerInvoices']) ? $data['CustomerInvoices'] : array(); 
            $dataInvoiceItem = isset($data['CustomerInvoiceItems']) ? $data['CustomerInvoiceItems'] : array();
            $model->attributes = $dataInvoice;
            $model->invoice_status_id = CustomerInvoices::STATUS_DRAFT;
            $arrdataInvoiceItem = [];
            foreach ($dataInvoiceItem as $item) {
                  $arrdataInvoiceItem[] = $item;
            }
            foreach($arrdataInvoiceItem as $index => $item) { 
                    $invoiceItem[$index] = new \common\models\CustomerInvoiceItems();
                    $invoiceItem[$index]->attributes = $item;
            }
            foreach ($invoiceItem as $index => $item) {
                    if($model->validate() && $invoiceItem[$index]->validate()) {
                         $saveData = true;
                    }
                    else {
                        $saveData = false;
                    }
            }
       }
      if($saveData==true) {
            $model->created_by = Yii::$app->user->getId();
            if($model->save(false) ){
                $max_number = CustomerInvoices::find()->where(['owner_id' => $owner_id])->max('invoice_number');
                $invoiceNumber->options = $max_number + 1;
                $invoiceNumber->save(false);
                foreach ($invoiceItem as $index => $item) {
                    $invoiceItem[$index]->invoice_id = $model->id;
                    $invoiceItem[$index]->save();
                }
                Yii::$app->session->setFlash('msg_success', Yii::t('app', 'Create invoice is successfully.'));
                return $this->redirect(['view','id' => $model->id]);
            }
           
        }
        return $this->render('@common/views/invoice/create.phtml',
                               [  
                                    'model' => $model,
                                    'invoiceItem' => $invoiceItem,
                                    'customer_id' => $customer_id
                               ]);

    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       $model = $this->findModel($id);
       if($model->invoice_status_id == CustomerInvoices::STATUS_PAID) {
           Yii::$app->session->setFlash('msg_error', Yii::t('app', 'Cannot edit invoice with status is paid.'));
           return $this->redirect(['index']);
       }
       $invoiceItem = \common\models\CustomerInvoiceItems::find()->where(['invoice_id'=>$model->id])->all();
       $data = Yii::$app->request->Post();
       $saveData = false;
      
       if(Yii::$app->request->isPost) {
           
           $dataInvoice = isset($data['CustomerInvoices']) ? $data['CustomerInvoices'] : array(); 
           $dataInvoiceItem = isset($data['CustomerInvoiceItems']) ? $data['CustomerInvoiceItems'] : array();
           $model->attributes = $dataInvoice;
           $arrdataInvoiceItem = [];
           foreach ($dataInvoiceItem as $item) {
               $arrdataInvoiceItem[] = $item;
           }
         
                foreach ($arrdataInvoiceItem as $index => $item) {
                 
                    $invoiceItem[$index] = new \common\models\CustomerInvoiceItems();
                    $invoiceItem[$index]->attributes = $item;
                      
                }
                
                foreach ($invoiceItem as $index => $item) {
                     if($model->validate() && $invoiceItem[$index]->validate()) {
                         $saveData = true;
                     }
                     else {
                         $saveData = false;
                        
                     }
                }
       }
       if($saveData==true) {
           $model->date = strtotime($model->date);
           if($model->save(false) ){
              
                $invoiceNumber = \common\models\UserSettings::getInvoiceNumber($model->owner_id);
                $max_number = CustomerInvoices::find()->where(['owner_id' => $model->owner_id])->max('invoice_number');
                $invoiceNumber->options = $max_number + 1;
                $invoiceNumber->save(false);
                \common\models\CustomerInvoiceItems::deleteAll(['invoice_id'=>$model->id]);
                foreach ($invoiceItem as $index => $item) {
                         $invoiceItem[$index]->invoice_id = $model->id;
                         $invoiceItem[$index]->save(false);
                 }
                Yii::$app->session->setFlash('msg_success', Yii::t('app', 'Update invoice is successfully.'));
                return $this->redirect(['view','id' => $model->id]);
           }
          
       }
      
       return $this->render('@common/views/invoice/update.phtml',
                                [  
                                    'model' => $model,
                                    'invoiceItem' => $invoiceItem,
                                ]);

    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model) {
                $model->deleted = CustomerInvoices::DELETED_YES;
                $model->save(false);
                
        } 
        Yii::$app->session->setFlash('msg_success', Yii::t('app', 'Delete invoice is successfully.'));
        if(isset(Yii::$app->session['report_invoice'])) {
            return $this->redirect(['/report/invoice']);
        }
        return $this->redirect(['index', 'customer_id'=> $model->customer_id]);
    }
    
    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUndelete($id)
    {
         $model = $this->findModel($id);
         $model->deleted = CustomerInvoices::DELETED_NO;
         $model->save(false);
         Yii::$app->session->setFlash('msg_success', Yii::t('app', 'Undelete invoice is successfully.'));
         return $this->redirect(['index', 'customer_id'=> $model->customer_id]);
    }
    
    /*
     * function ajax get dropdown
     * return $mixed
     */
    public function actionJobs($customer_id) 
    {
       $model = new CustomerInvoices();
       $get = Yii::$app->request->get('customer_id'); 
       $data= array();
       if(isset($get)) {
           $data = $model->getDropDownListJobs($get);
       }
       $view = $this->renderAjax('@common/views/invoice/ajax/_jobs.phtml',['model' => $data]);
       return json_encode(array('status'=> true,'view'=>$view));
       Yii::$app->end();
    }
    
    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateInvoiceItem($owner_id = null)
    {
       $index = Yii::$app->request->get('index');
       if(!$owner_id) {
            $owner_id = Yii::$app->user->identity->getOwnerId();
       }
       $invoiceItem[$index] = new \common\models\CustomerInvoiceItems();
       $view = $this->renderAjax('@common/views/invoice/ajax/_invoice_item.phtml',
                    ['invoiceItem'=>$invoiceItem,'index'=>$index,'owner_id'=>$owner_id]);
       
       return json_encode(['status'=>true,'data'=>$view]);
    }

    /**
     * view PDF
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id)
    {
        $owner_id = Yii::$app->user->identity->getOwnerId();
        $model = $this->findModel($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $this->layout = null;
        $content = $this->renderPartial('@common/views/pdf/invoice.phtml',['model'=>$model]);
        //echo $content;
        //return $content;
        $pdf = new Pdf([
        // set to use core fonts only
            'mode' => Pdf::MODE_UTF8, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@public/css/pdf.css',
            // any css to be embedded if required
            //'cssInline' => '.kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => 'Invoice'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>['Invoice'], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        // return the pdf output as per the destination setting
        return $pdf->render(); 
    }

     /**
     * sent email to customer
     * @param integer $id
     * @return mixed
     */
    public function actionSentEmail($id)
    {
        $from = Yii::$app->request->get('from');
        $model = $this->findModel($id);

        if(!empty($model) && $model->sendEmail())
        {
            if($model->invoice_status_id == CustomerInvoices::STATUS_DRAFT)
            {
                $model->invoice_status_id = CustomerInvoices::STATUS_SENT;
                $model->save();
            }    
            
            Yii::$app->session->setFlash('success', Yii::t('app', 'Sent email to customer successfully.'));
        }
        else
        {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Sent email to customer failed.'));
        }
        if($from == 'job')
        {
            return $this->redirect(['/jobs/default/view','id'=>$model->job_id]);
        }
        return $this->redirect(['view', 'id' => $id]);
    }
    
    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CustomerInvoices::findOne($id)) !== null) {
            $user = User::findOne(Yii::$app->user->getId());
            if(isset($model->owner_id) && $model->owner_id != $user->getOwnerId()) {
                   throw new NotFoundHttpException('The requested page does not exist.');
            }
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
 }