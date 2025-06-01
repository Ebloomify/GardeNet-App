export default {
	init: () => {
		// #ifdef APP-PLUS
		plus.push.setAutoNotification(true);  //设置通知栏显示通知 //必须设置
		plus.push.addEventListener("click", function(msg) {
			console.log('点击事件');
			console.log(msg);
			plus.push.clear(); //清空通知栏
			pushHandle(msg) //处理方法
		}, false);
		// 监听在线消息事件    
		plus.push.addEventListener("receive", function(msg) {
			console.log('在线监听到的透传');
			console.log(msg);
			if (plus.os.name=='iOS') {  //由于IOS 必须要创建本地消息 所以做这个判断
				if (msg.payload&& msg.payload!=null&&msg.type=='receive') {
					// {"title": "xxx","content": "xxx","payload": "xxx"} 符合这种 才会自动创建消息  文档地址https://ask.dcloud.net.cn/article/35622
					plus.push.createMessage(msg.payload.body,JSON.stringify(msg.payload))  //创建本地消息
				}
			}
			if (plus.os.name=='Android') {
				if(msg.title &&  msg.content && msg.payload){ //  符合自动创建消息的情况
					 //这里根据你消息字段来创建消息
					plus.push.createMessage(msg.payload.body,JSON.stringify(msg.payload))  //创建本地消息
					// plus.push.createMessage("创建本地消息")  //创建本地消息
				}else{
					//不符合自动创建消息
					// pushHandle(msg)
				}	
			}
			 	
		}, false);
		// #endif
	},

	getClient: (callback) => {
		// #ifdef APP-PLUS
		let clientInfo = plus.push.getClientInfo();  //获取 clientID
		uni.setStorageSync('clientid', clientInfo.clientid)
		// console.log(clientInfo);
		// #endif

	},

}
const pushHandle = (msg) => {
	console.log('单击了消息')
	console.log(msg)
	if (typeof (msg.payload )=='string') {  //如果是字符串，表示是ios创建的  要转换一下
		msg.payload=JSON.parse(msg.payload )
	}
	if(!msg) return false;
	plus.runtime.setBadgeNumber(0); //清除app角标
	
	//下面的代码根据自己业务来写 这里可以写跳转业务代码
	msg.payload.urlStr = decodeURIComponent(msg.payload.urlStr);
	//跳转到tab
	if (msg.payload.urlType == 2) {
		uni.switchTab({
			url: msg.payload.urlStr
		})
	}
	//跳转到详情
	if (msg.payload.urlType == 1) {
		let url = msg.payload.urlStr
		uni.navigateTo({
			url: url
		})
	}
}
