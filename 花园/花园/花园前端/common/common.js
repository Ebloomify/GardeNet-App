// http://mygarden.ttest.vip/
const ajaxUrl = 'http://gardenet.ebloomify.com/api';
const imgUrl = 'http://gardenet.ebloomify.com/';
const timeOut = 10000;
const pageSize = 20;
import store from '@/store';
const getData = function(datas, url, methods) {
	return new Promise(function(resolve, reject) {
		uni.request({
			data: datas || {},
			method: methods || 'POST',
			url: ajaxUrl + url,
			header: {
				'content-type': 'application/x-www-form-urlencoded',
				Authorization: store.state.token || ""
				// 'content-type': 'application/json'
			},
			timeout: timeOut,
			success(res) {
				if (res.statusCode == 200) {
					resolve(res.data);
				} else {
					reject({
						msg: "服务器错误"
					});
				}
			},
			fail(err) {
				failFn(err);
				reject(err);
			},
			complete(e) {
				// console.log(e);
				uni.hideLoading();
				uni.stopPullDownRefresh()
			}
		});
	});
};

//请求失败处理
const failFn = function(err) {
	console.log(err)
	uni.hideLoading();
	if (err.errMsg == 'request:fail') {
		showToast('服务器走丢了');
	} else if (err.errMsg == 'request:fail timeout') {
		showToast('请求超时');
	} else {
		showToast('获取数据失败');
	}
};

const showToast = function(text, status) {
	uni.showToast({
		icon: status || 'none',
		title: text,
		position: "bottom"
	})
}

// 时间戳转时间
const initTime = (timestamp, type) => {
	// 设置达拉斯时间
	var dallasTime = timestamp - (1000 * 60 * 60 * 13)
	var date = new Date(dallasTime); //时间戳为10位需*1000，时间戳为13位的话不需乘1000
	var Y = date.getFullYear();
	var M = date.getMonth() + 1;
	M = M < 10 ? ('0' + M) : M;
	var D = date.getDate();
	D = D < 10 ? ('0' + D) : D;
	var h = date.getHours();
	h = h < 10 ? ('0' + h) : h;
	var m = date.getMinutes();
	m = m < 10 ? ('0' + m) : m;
	var s = date.getSeconds();
	s = s < 10 ? ('0' + s) : s;
	if (type == 'day') {
		return `${Y}-${M}-${D}`;
	} else {
		return `${Y}-${M}-${D} ${h}:${m}:${s}`;
	}
}

const getCid = () => {
	// {
	// 	"id": "unipush",
	// 	"token": "3c84807d4e9af67ecb61c61649c322d1",
	// 	"clientid": "3c84807d4e9af67ecb61c61649c322d1",
	// 	"appid": "5zVkWqYeWI8imIpfOwhVb5",
	// 	"appkey": "MAwkLsIyac8yKjUaLw69P7"
	// }

	var clientInfo = '';
	// #ifdef APP-PLUS
	var clientInfo = plus.push.getClientInfo();
	// #endif
	return clientInfo;
};

const getNextDate = (day) => {
	var dd = new Date();
	dd.setDate(dd.getDate() + day);
	var y = dd.getFullYear();
	var m = dd.getMonth() + 1 < 10 ? "0" + (dd.getMonth() + 1) : dd.getMonth() + 1;
	var d = dd.getDate() < 10 ? "0" + dd.getDate() : dd.getDate();
	return y + "-" + m + "-" + d;
};

// 设置手机通知权限
const setPermissions = () => {
	// #ifdef APP-PLUS  
	if (plus.os.name == 'Android') { // 判断是Android
		var main = plus.android.runtimeMainActivity();
		var pkName = main.getPackageName();
		var uid = main.getApplicationInfo().plusGetAttribute("uid");
		var NotificationManagerCompat = plus.android.importClass(
		"android.support.v4.app.NotificationManagerCompat");
		//android.support.v4升级为androidx
		if (NotificationManagerCompat == null) {
			NotificationManagerCompat = plus.android.importClass("androidx.core.app.NotificationManagerCompat");
		}
		var areNotificationsEnabled = NotificationManagerCompat.from(main).areNotificationsEnabled();
		console.log(areNotificationsEnabled)
		// 未开通‘允许通知’权限，则弹窗提醒开通，并点击确认后，跳转到系统设置页面进行设置  
		if (!areNotificationsEnabled) {
			uni.showModal({
				title: 'Tips',
				content: 'You have not yet enabled notification permissions and cannot receive message notifications. Please go to Settings!',
				showCancel: false,
				confirmText: 'Go set up',
				success: function(res) {
					if (res.confirm) {
						var Intent = plus.android.importClass('android.content.Intent');
						var Build = plus.android.importClass("android.os.Build");
						//android 8.0引导  
						if (Build.VERSION.SDK_INT >= 26) {
							var intent = new Intent('android.settings.APP_NOTIFICATION_SETTINGS');
							intent.putExtra('android.provider.extra.APP_PACKAGE', pkName);
						} else if (Build.VERSION.SDK_INT >= 21) { //android 5.0-7.0  
							var intent = new Intent('android.settings.APP_NOTIFICATION_SETTINGS');
							intent.putExtra("app_package", pkName);
							intent.putExtra("app_uid", uid);
						} else { //(<21)其他--跳转到该应用管理的详情页  
							intent.setAction(Settings.ACTION_APPLICATION_DETAILS_SETTINGS);
							var uri = Uri.fromParts("package", mainActivity.getPackageName(), null);
							intent.setData(uri);
						}
						// 跳转到该应用的系统通知设置页  
						main.startActivity(intent);
					}
				}
			});
		}
	} else if (plus.os.name == 'iOS') { // 判断是ISO
		var isOn = undefined;
		var types = 0;
		var app = plus.ios.invoke('UIApplication', 'sharedApplication');
		var settings = plus.ios.invoke(app, 'currentUserNotificationSettings');
		if (settings) {
			types = settings.plusGetAttribute('types');
			plus.ios.deleteObject(settings);
		} else {
			types = plus.ios.invoke(app, 'enabledRemoteNotificationTypes');
		}
		plus.ios.deleteObject(app);
		isOn = (0 != types);
		if (isOn == false) {
			uni.showModal({
				title: 'Tips',
				content: 'You have not yet enabled notification permissions and cannot receive message notifications. Please go to Settings!',
				showCancel: false,
				confirmText: 'Go set up',
				success: function(res) {
					if (res.confirm) {
						var app = plus.ios.invoke('UIApplication', 'sharedApplication');
						var setting = plus.ios.invoke('NSURL', 'URLWithString:', 'app-settings:');
						plus.ios.invoke(app, 'openURL:', setting);
						plus.ios.deleteObject(setting);
						plus.ios.deleteObject(app);
					}
				}
			});
		}
	}
	// #endif  
}


export default {
	ajaxUrl: ajaxUrl,
	imgUrl: imgUrl,
	timeOut: timeOut,
	getData: getData,
	showToast: showToast,
	pageSize: pageSize,
	initTime: initTime,
	getCid: getCid,
	getNextDate: getNextDate,
	setPermissions: setPermissions
};