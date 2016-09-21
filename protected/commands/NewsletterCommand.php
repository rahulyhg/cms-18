<?php


class NewsletterCommand extends CConsoleCommand
{
    protected $max = 10;
    protected $index = 0;
    protected $data = array();

    public function run($arg)
    {
        $this->doJob($arg);
        CmsEmail::mailAll($this->data);
        Yii::app()->setting->setDbItem('last_working', date('Y-m-d h:i:s'));
    }

    protected function doJob($arg)
    {
        $model = Newsletter::model()->find(array(
            'condition'=>'t.remain_subscribers IS NOT NULL AND length(t.remain_subscribers) > 0 AND t.send_time <= NOW() and status=1',
            'order'=>'t.id ASC',
        ));

        if($model !== null)
        {
            $subscriber_count = 0;
            $receivers = explode(',', $model->remain_subscribers);
            while(count($receivers) > 0)
            {
                $k = array_shift($receivers);
                if(empty($k)) continue; // add by Nguyen Dung
                $s = Subscriber::model()->findByPk($k);                
                if($s)
                    if($s->status==0) continue; // add by Nguyen Dung

                $url=Yii::app()->setting->getItem('baseUrl').'/site/track_newsletter?newsletter_id='.$model->id.'&subscriber_email='.$s->email;
                $img_track_read_email = '<img src="'.$url.'" alt="" height="1" width="1"/>';
                $unsubscribe ="You received this message because you are subsribed to the AbtUS Singapore newsletter. Please click here (".CHtml::link('Link Unsubscriber',Yii::app()->setting->getItem('baseUrl').'/site/unsubscribe?id='.$s->id.'&code='.md5($s->id.$s->email)).") to unsubscribe." ;
                
                $r = array(
                    'subject'=>$model->subject,
                    'params'=>array(
                        'content'=>$model->content.$img_track_read_email.$unsubscribe,
                        'newsletterName'=> Yii::app()->setting->getItem('projectName'),
                         'unsubscribe'=> Yii::app()->setting->getItem('baseUrl').'/site/unsubscribe?id='.$s->id.'&code='.md5($s->id.$s->email),
                    ),
                    'view'=>'newsletter',
                    'to'=>$s->email,
                    //'from'=> Yii::app()->params['autoEmail'],
                    'from'=> Yii::app()->params['EmailSendSubscriber'],
                );
                
                $this->data []= $r;
                $subscriber_count++;//count subscriber is served for current newsletter job
                $this->index++;//count email is sent for current cron job
                if($this->index >= $this->max)
                    break;                
            }
            
            $model->total_sent = $model->total_sent+$subscriber_count; // track amount mail sent
            $model->remain_subscribers = implode(',', $receivers);
            $model->update(array('remain_subscribers','total_sent'));
        }
        else
        {
            return;
        }

        //when sent all subscriber of a newsletter job but the
        if($this->index < $this->max)
            $this->doJob($arg);
    }



/*    protected function doJob($arg)
    {
        try {
             //$model = Newsletter::model()->findByPk(40);
                $model = Newsletter::model()->find(array(
                    'condition'=>'t.remain_subscribers IS NOT NULL AND t.send_time <= NOW() and status=1',
                    'order'=>'t.id ASC',
                ));

                $subscriber_count = 0;
                $receivers = explode(',', $model->remain_subscribers);
                $tmp =array();
                if(is_array($receivers)&& count($receivers)>0){
                    foreach($receivers as $itemMail){
                        $s = Subscriber::model()->findByPk($itemMail);
                        try{
                            Yii::app()->setting->setDbItem('last_working',$s->email); 
                            $url=Yii::app()->setting->getItem('baseUrl').'/site/track_newsletter?newsletter_id='.$model->id.'&subscriber_email='.$s->email;
                            $img_track_read_email = '<img src="'.$url.'" alt="" height="1" width="1"/>';
                            $unsubscribe = CHtml::link('Link Unsubscriber',Yii::app()->setting->getItem('baseUrl').'/site/unsubscribe?id='.$s->id.'&code='.md5($s->id.$s->email));
                            $r = array(
                                'subject'=>$model->subject,
                                'params'=>array(
                                    'content'=>$model->content.$img_track_read_email .$unsubscribe,
                                    'newsletterName'=> Yii::app()->setting->getItem('projectName'),
                                    'unsubscribe'=> Yii::app()->setting->getItem('baseUrl').'/site/unsubscribe?id='.$s->id.'&code='.md5($s->id.$s->email),
                                ),
                                'view'=>'newsletter',
                                'to'=>$s->email,
                                'from'=> Yii::app()->params['EmailSendSubscriber'],
                            );   
                            CmsEmail::mail($r); 
                            $subscriber_count +=1;

                            $this->data []= $r;
                            $subscriber_count++;//count subscriber is served for current newsletter job
                            $this->index++;//count email is sent for current cron job
                            if($this->index >= $this->max)
                                break;

                        } catch (exception $e) {
                            $tmp[]=$itemMail;
                            Yii::app()->setting->setDbItem('last_working', $e); 

                        }
                    }

                    if(is_array($tmp) && count($tmp)>0){
                         $receivers = implode(',', $tmp);
                    }else{
                         $receivers = '';
                    }
                   
                    $model->total_sent = $model->total_sent+$subscriber_count; // track amount mail sent
                    $model->remain_subscribers = $receivers;
                    $model->update(array('remain_subscribers','total_sent'));  

                }else{
                    $model->total_sent = $model->total_sent+$subscriber_count; // track amount mail sent
                    $model->remain_subscribers = null;
                    $model->update(array('remain_subscribers'));                     
                }

                //when sent all subscriber of a newsletter job but the
                if($this->index < $this->max)
                    $this->doJob($arg);


        } catch (exception $e) {
            Yii::app()->setting->setDbItem('last_working', $e); 
        }        
    }
*/





}

