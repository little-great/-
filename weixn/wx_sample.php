<?php
/**
  * wechat php test
  */
include_once 'weisdk.php';
//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();
class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                
              	$fromUsername = $postObj->FromUserName;
		        $toUsername = $postObj->ToUserName;
				$msgType = $postObj->MsgType;
				$event = $postObj->Event;
				$keyword = trim($postObj->Content);
				$time = time();  
				$textTpl = "<xml>
									<ToUserName><![CDATA[%s]]></ToUserName>
									<FromUserName><![CDATA[%s]]></FromUserName>
									<CreateTime>%s</CreateTime>
									<MsgType><![CDATA[%s]]></MsgType>
									<Content><![CDATA[%s]]></Content>
									<FuncFlag>0</FuncFlag>
							</xml>";
           
                switch($msgType){
//关注事件回复
                	case "event":
                		if($event=="subscribe")
                		{
                			$contentStr="感谢您的关注么么哒\n回复1查看号主姓名\n回复2查看号主女票姓名\n回复3去百度\n回复4查看合照\n回复5查看女票照片\n回复6玩游戏“黄金矿工";
                			$msgType = "text";
                			$resultStr = sprintf($textTpl, $fromUsername,$toUsername,$time,$msgType,$contentStr);
                			echo $resultStr;
                	
                		}
                		break;
                                                                                                             //关注事件结束
//关键字回复   	
                	case"text":
              		
               switch($keyword)
                		{
                			case"1":
                				$contentStr="张博";
                				$msgType = "text";
                				$resultStr = sprintf($textTpl, $fromUsername,$toUsername,$time,$msgType,$contentStr);
                				echo $resultStr;
                				break;
                			case"2":
                				$contentStr="张博";
                				$msgType = "text";
                				$resultStr = sprintf($textTpl, $fromUsername,$toUsername,$time,$msgType,$contentStr);
                				echo $resultStr;
                				break;
                			case"3":
                				$contentStr="<a href='http://www.baidu.com'>去百度</a>";
                				$msgType = "text";
                				$resultStr = sprintf($textTpl, $fromUsername,$toUsername,$time,$msgType,$contentStr);
                				echo $resultStr;
                					break;
//单图文消息回复
                 			case"4":
                 				
                				$singenews="<xml>
                						<ToUserName><![CDATA[%s]]></ToUserName>
                						<FromUserName><![CDATA[%s]]></FromUserName>
                						<CreateTime>%s</CreateTime>
                						<MsgType><![CDATA[%s]]></MsgType>
                						<ArticleCount>1</ArticleCount>
                						<Articles>
                						<item>
                						<Title><![CDATA[%s]]></Title>
                						<Description><![CDATA[%s]]></Description>
                						<PicUrl><![CDATA[%s]]></PicUrl>
                						<Url><![CDATA[%s]]></Url>
                						</item>
                						</Articles>
                						</xml>";
                				$msgType = "news";
                				$title="傻狗狗与坏臭臭";
                				$description="我们已经两年了";
                				$picurl="http://1.yidianyouxiu.applinzi.com/images/001.jpg";
                				$Url="https://m.taobao.com/";
                				//$url="";
                				$resultStr = 
                				sprintf($singenews,$fromUsername,$toUsername,$time,$msgType,$title,$description,$picurl,$Url);
                				echo $resultStr;
                				break;
				                                                                                            //单图文消息回复结束
//多图文消息回复
                 			case"5":
                 				$multinews="<xml>
                						<ToUserName>$fromUsername</ToUserName>
                						<FromUserName>$toUsername</FromUserName>
                						<CreateTime>$time</CreateTime>
                						<MsgType><![CDATA[news]]></MsgType>
                						<ArticleCount>2</ArticleCount>
                						<Articles>
                						<item>
                						<Title><![CDATA[漂亮的傻狗狗]]></Title>
                						<Description><![CDATA[漂亮]]></Description>
                						<PicUrl><![CDATA[http://1.yidianyouxiu.applinzi.com/images/002.jpg]]></PicUrl>
                						</item>
                 						<item>
                						<Title><![CDATA[可爱的傻狗狗]]></Title>
                						<Description><![CDATA[可爱]]></Description>
                						<PicUrl><![CDATA[http://1.yidianyouxiu.applinzi.com/images/003.jpg]]></PicUrl>
                						</item>
                						</Articles>
                						</xml>";
                 				echo $multinews; 
                 				break;
                 				case"6":
                 					$contentStr="<a href='http://h.lexun.com/game/GoldNuggets/play.aspx'>黄金矿工</a>";
                 					$msgType = "text";
                 					$resultStr = sprintf($textTpl, $fromUsername,$toUsername,$time,$msgType,$contentStr);
                 					echo $resultStr;
                 					break;
                				

                                                                                                            //多图文消息回复结束
                                                                                                            //关键字回复结束
//文本消息回复
                				default:
                				$contentStr= "回复1查看号主姓名\n回复2查看号主女票姓名\n回复3去百度\n回复4查看合照\n回复5查看女票照片\n回复6玩游戏“黄金矿工";
                				$msgType = "text";
                				$resultStr = sprintf($textTpl, $fromUsername,$toUsername,$time,$msgType,$contentStr);
                				echo $resultStr;
                                                                                                          //文本消息回复结束
                                                                                                          
                				
                				
                
                		
    /*            		
//天气查询接口开始
                		$ch = curl_init();
                		//将“city”后的值换为用户输入的值
                		$url = "http://apis.baidu.com/heweather/weather/free?city=$keyword";
                		$header = array(
                				//放入申请的apikey
                				'apikey: 8ea97b51612d9cebb60761048c430a20',
                		);
                		// 添加apikey到header
                		curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
                		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                		// 执行HTTP请求
                		curl_setopt($ch , CURLOPT_URL , $url);
                		//$res是个json数据，然后解析json
                		$res = curl_exec($ch);      
                		//加上true后转化为数组，不加转化为函数
                		$arr=json_decode($res,true);
                		$contentStr=$arr['retData']['city']."\n".$arr['retData']['date']."\n".$arr['retData']['weather']."\n".$arr['retData']['l_tmp']
                		."\n".$arr['retData']['h_tmp']."\n".$arr['retData']['WS'];
                		$msgType = "text";
                		$resultStr = sprintf($textTpl, $fromUsername,$toUsername,$time,$msgType,$contentStr);
                		echo $resultStr;
                		
                		
                     json返回值
{
errNum: 0,
errMsg: "success",
retData: {
   city: "北京", //城市
   pinyin: "beijing", //城市拼音
   citycode: "101010100",  //城市编码	
   date: "15-02-11", //日期
   time: "11:00", //发布时间
   postCode: "100000", //邮编
   longitude: 116.391, //经度
   latitude: 39.904, //维度
   altitude: "33", //海拔	
   weather: "晴",  //天气情况
   temp: "10", //气温
   l_tmp: "-4", //最低气温
   h_tmp: "10", //最高气温
   WD: "无持续风向",	 //风向
   WS: "微风(<10m/h)", //风力
   sunrise: "07:12", //日出时间
   sunset: "17:44" //日落时间
  }    
}

           		                                                                                  //天气查询接口结束
           		                                                                                  
 */
                		
                		
                		}
                		break; 
               
                
               // echo $resultStr;
				
		}}else {
        	echo "";
        	exit;
        }
    }
		
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}


?>