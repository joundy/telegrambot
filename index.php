<?php

require_once('db.php');

class teleBot{
    public $api = ':';
    public $apiUrl = 'https://api.telegram.org';

    public $method;
    public $update;

    public function getUpdate(){
        $update = json_decode(file_get_contents("php://input"),TRUE);
        $this->update = $update;
    }

    public function getLastChat($id){
        $getLog = substr_replace(file_get_contents('log_telegram.txt'), "", -1);
        $getLog = explode('|',$getLog);

        for ($i=0; $i < count($getLog); $i++) { 
            $getLogId = $getLog[$i];
            $getLogId = explode(',',$getLogId);
            
            if($getLogId[0] == $id){
                $chat = $getLogId[1];
            }
        }
        return $chat;
    }
    

    public function method($m){
        $chatId = $this->update["message"]["chat"]["id"];

        switch ($m['type']) {
            case 'sendMessage':
                $this->method = 'sendMessage?chat_id='.$chatId.'&text='.$m['data'];
                return $this;
                break;
            default:
                break;
        }
    }

    public function start(){
        $DB = new DB();

        $this->getUpdate();
        $chatId = $this->update["message"]["chat"]["id"];                

        switch ($this->update['message']['text']) {
            case '/start':
                $this->method([ 
                    'type'=> 'sendMessage',
                    'data'=>'Selamat Datang di Jondes Bot'
                ])->exec();
                break;
            case '/cek':
                
                $getUser = $DB->getUserById($chatId);

                if(count($getUser) !== 0){
                    $this->method([
                        'type'=> 'sendMessage',
                        'data'=>'Anda sudah registrasi, silahkan cek data dengan /info'
                    ])->exec();
                }
                else{
                    $this->method([
                        'type'=> 'sendMessage',
                        'data'=>'Anda belum registrasi, silahkan registrasi di @d_n_s_bot'
                    ])->exec();
                }

                break;

            case '/info':
                
                $getUserInfo = $DB->getUserInfo($chatId);

                if(count($getUserInfo) !== 0){
                    $this->method([
                        'type'=> 'sendMessage',
                        'data'=> $getUserInfo[0]['nama']
                    ])->exec();
                }
                else{
                    $this->method([
                        'type'=> 'sendMessage',
                        'data'=>'Anda belum registrasi, silahkan registrasi di @d_n_s_bot'
                    ])->exec();
                }

                break;
            default:
                $this->method([
                    'type'=> 'sendMessage',
                    'data'=> $this->getLastChat($this->update["message"]["chat"]["id"])
                ])->exec();
                break;
        }
    }
    
    public function exec(){
        $log = $this->update['message']['chat']['id'].','.$this->update['message']['text'].'|';
        $this->storeLog($log);

        $url = $this->apiUrl.'/bot'.$this->api.'/'.$this->method;
        file_get_contents($url);
    }

    public function storeLog($log_msg){   
        $log_file_data = 'log_telegram.txt';
        file_put_contents($log_file_data, $log_msg, FILE_APPEND);
    }
    
}

$teleBot = new teleBot();
$teleBot->start();

//jondesbotv01
