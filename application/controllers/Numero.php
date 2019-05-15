<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Numero extends MY_Controller
{
   
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model'); 
        $this->load->model('Project2_model','main_model');
        $this->load->model('Projects_model','main_model');
        if(!$this->isLoggedIn()){  
            redirect(base_url());
        };   
          
    }


    public function index()  
    {
        
        $post = [
            '__EVENTTARGET'     => null, 
            '__EVENTARGUMENT'   => null,
            '__VIEWSTATE'       => 'nNQZS/6negbuduLRzWDWIfEsPghIpYaXP1XPh2ewVc4HGw7heYBJTHRTNUjPlQzvipQJDaM/d2xY2Ct1lDhm6muNX3ZT9t9rLJUNDulwG0Ear4mDSbab/wBaKpOm5bAQeIpqCvB/kQgx4ma97PXuUR1ET5Y6XTZliMS/l8Wo8AkPzlopHZ5vnhsKLA9d+7Q/ajq8ZbLAH/GckxTf5fq5MnZ7hu77dIYxEEqxi1m8lVJW9Nj9ovyEtkL5cEIoxXDlXFzBzlpHy4+c35IEpVvaoxNHyTKLq+rrbmQ2IUZUh9K8cVHVoh+XLC7IR1EsItGhSK+S0h0qNtniAatE3tNuSDOH9ZetixmYlPHj6EKHXPjabH3KLIpzfTPvWfAKrz9ix9VFVG6GSNqCII1lyjMgU1RAAIVamDgVT8igyK+ioqXz9Y/pPtoexuvDQVkfy7BJvKcu8bKQZ82v6c006JHXhZsmKCNklevMGBC/w9IUrsTIKbmR5in+N47U2mu3uTGgPdRdrtDQNFYKPQv6nJYsw9ima879K1J8kk3ctuJVJ1oLCsJ5bkw82JC5QgyyIgwK8jyXvfvUU5DiD3E7i1LxFlGAsQDZ0YYtHV/QIMs3uop6pjPumV4eO68e/b3Lp/bdf5v3j/pFa8NvANB2J4rJYo6nOzZ601cQFUJy08vF6c2jFyHRRbQwcBSXVYk0Db1dM5CJ26chwmKnVMdTEz5NRjW9ef0o1LHGHWFJfcQVyJujHlOW7RPjWObC8PVX3tFqR1WVPcr7tRq3RMrxuxLWSU5TsxMQMdWUrGwqcQOEc94TqGQOkUBh/rQyGkKJWkbKG92EzyoD6WIfaNHicD5cd6uVJDiPrwzPB1AuSbZf84+oRozDHiI1aUsOaxdoR+lbFK0YmLfNiu2gaNy5u4ZmEQ==',
            '__EVENTVALIDATION' => 'PaczI+Uzd4bE2yWg+1E0Wzi0J+TrGLQrDLJBFiIeP9qkDfnQVD/0XFeuMlgchL6Ooe0RKWg8PhXPvbv5ZsVRJZcDZ7+J4sdE4IqamGF0qfl7Y4SC62jW9fFeaL4mCYeK',
            'ctl00$MainContentPlaceHolder$SearchPanel$SearchPanelLayout$txtIDUser'  => 'Guest',
            'ctl00_MainContentPlaceHolder_SearchPanel_SearchPanelLayout_cbAKses_VI' => 'OBL',
            'ctl00$MainContentPlaceHolder$SearchPanel$SearchPanelLayout$cbAKses'    => 'OBL',
            'ctl00$MainContentPlaceHolder$SearchPanel$SearchPanelLayout$cbAKses$DDDState' => '{&quot;windowsState&quot;:&quot;0:0:-1:74:239:1:365:125:1:0:0:0&quot;}',
            'ctl00$MainContentPlaceHolder$SearchPanel$SearchPanelLayout$cbAKses$DDD$L'      => 'OBL',
            'ctl00$MainContentPlaceHolder$SearchPanel$SearchPanelLayout$txtPassword'=> 'Telkom',
            'ctl00$MainContentPlaceHolder$SearchPanel$SearchPanelLayout$SearchButton'       => 'LOGIN',
            'ctl00$MainContentPlaceHolder$SearchPanel$pcPopupState' => '{&quot;windowsState&quot;:&quot;0:0:-1:412:331:0:-10000:-10000:1:0:0:0&quot;}',
            'DXScript'  =>  '1_240,1_163,1_137,1_173,1_140,1_176,1_161,1_169,1_234,1_142,1_175,1_160,1_134,1_226,1_158,1_224,1_164,1_150',
            'DXCss'     => '1_28,1_31,1_10,0_3071,0_3175,0_3069,0_3173,icons/ICONNUMERO.png,ContentDefault/Styles.css'
        ];

        $ch = curl_init('https://numero.telkom.co.id/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        // execute!
        $response = curl_exec($ch);

        // close the connection, release resources used
        //curl_close($ch);

        // do anything you want with your response
        //var_dump($response);


        // $ch = curl_init('http://numero.telkom.co.id/GlobalOBL.aspx');
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // // execute!
        // $response = curl_exec($ch);

        // // close the connection, release resources used
        // curl_close($ch);

        // // do anything you want with your response
        // var_dump($response);

        $this->myView('project/numero',null);
                     
        }
     
    
}

?> 