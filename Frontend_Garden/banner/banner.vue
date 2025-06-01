<template>
	<view>

	</view>
</template>

<script>
	export default {
		data() {
			return {
				isInit: false,
				// iOSAdId: "/21775744923/example/app-open", // 苹果-测试
				iOSAdId: "ca-app-pub-5707161891548694/9385083158", // 苹果-正式
				iOSAppId: "ca-app-pub-5707161891548694~2406680372",
				// AndroidAdId: "ca-app-pub-5707161891548694/5327817443", // 安卓
				AndroidAdId: "ca-app-pub-5707161891548694/9403166005", // 安卓
				AndroidAppId: "ca-app-pub-5707161891548694~8595189944",
				systemInfo: {}
			}
		},
		onLoad() {
			// #ifdef APP-PLUS
			this.systemInfo = uni.getSystemInfoSync()
			var jygooglead = uni.requireNativePlugin("JY-GoogleAdMob");
			jygooglead.jy_init();
			// #endif
			// #ifndef APP-PLUS
			uni.reLaunch({
				url: "/pages/index/index",
				complete: (e) => {
					console.log(e);
				}
			})
			// #endif
		},
		onShow() {

			if (this.isInit) {
				uni.switchTab({
					url: '/pages/index/index'
				});
			} else {
				// #ifdef APP-PLUS
				this.systemInfo.platform === 'android' ? this.jy_loadInterstitialAd() : this.jy_loadAppOpenAD()
				// #endif
			}
		},
		methods: {
			// 已用---IOS
			jy_loadAppOpenAD() {
				var JYGoogleAdMob = uni.requireNativePlugin("JY-GoogleAdMob");
				JYGoogleAdMob.jy_loadAppOpenAD({
					adId: this.iOSAdId
				}, res => { // 数据格式见上面说明 
					console.log(res)
					plus.navigator.closeSplashscreen();
					if (res.errorCode == 0) {

						if (res.code == '100') {
							this.jy_showAppOpenAD();
						} else if (res.code == '104') {
							this.addInteger()
						} else if (res.code == '107') {

						} else if (res.code == '106') {
							// uni.showToast({
							// 	icon: 'none',
							// 	title: "AD-ERROR"
							// })
							uni.reLaunch({
								url: '/pages/index/index'
							});
						} else if (res.code == '103') {
							console.log('进入首页')
							uni.reLaunch({
								url: '/pages/index/index'
							});
						}

					} else if (res.errorCode == 1) {
						uni.reLaunch({
							url: '/pages/index/index'
						});
					}
				})

			},
			// 显示广告---IOS
			jy_showAppOpenAD() {
				var JYGoogleAdMob = uni.requireNativePlugin("JY-GoogleAdMob");
				JYGoogleAdMob.jy_showAppOpenAD({

				}, res => {
					uni.showToast({
						icon: 'none',
						title: JSON.stringify(res)
					})
				})
			},
			// 已用---安卓
			jy_loadInterstitialAd() {
				this.isInit = true;
				var jygooglead = uni.requireNativePlugin("JY-GoogleAdMob");
				jygooglead.jy_loadInterstitialAd({
						adId: this.systemInfo.platform === 'android' ? this.AndroidAdId : this.iOSAdId,
					},
					res => {
						console.log(res)
						// uni.showModal({
						// 	title: '提示',
						// 	content: JSON.stringify(res),
						// 	success: function(res) {

						// 	}
						// });
						plus.navigator.closeSplashscreen();
						if (res.errorCode == 0) {

							if (res.code == '100') {
								this.jy_showInterstitialAd();
							} else if (res.code == '104') {
								this.addInteger()
							} else if (res.code == '107') {

							} else if (res.code == '106') {
								// uni.showToast({
								// 	icon: 'none',
								// 	title: "AD-ERROR"
								// })
								uni.reLaunch({
									url: '/pages/index/index'
								});
							} else if (res.code == '103') {
								console.log('进入首页')
								uni.reLaunch({
									url: '/pages/index/index'
								});
							}

						} else if (res.errorCode == 1) {
							uni.reLaunch({
								url: '/pages/index/index'
							});
						}

					})
			},
			// 显示广告---安卓
			jy_showInterstitialAd() {
				var jygooglead = uni.requireNativePlugin("JY-GoogleAdMob");
				jygooglead.jy_showInterstitialAd({},
					res => {
						console.log(JSON.stringify(res));
						// uni.showToast({
						// 	icon: 'none',
						// 	title: JSON.stringify(res)
						// })
					})
			},
			// 广告后增加积分
			addInteger() {
				if (this.userInfo.token) {
					var datas = {
						type: 1,
						integer: 20,
						integer_dec: "Watch advertisements"
					}
					this.requestSet.getData(datas, "/V1.PlusMinusInteger/save", 'POST').then((res) => {
						console.log(res);
						if (res.status == 200) {

						}
					}).catch((err) => {
						console.log(err)
						this.isMark = true;
						this.markType = 2;
					});
				}
			}
		}
	}
</script>

<style>
	page {
		background-color: #000000;
	}
</style>