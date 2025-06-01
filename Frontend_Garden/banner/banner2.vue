<template>
	<view>

	</view>
</template>

<script>
	export default {
		data() {
			return {
				isInit: false,
				// adId: "ca-app-pub-3940256099942544/9257395921" // 安卓测试
				adId: "ca-app-pub-5707161891548694/5812051844" // 安卓
				// adId: "ca-app-pub-5707161891548694/9385083158" // 苹果
			}
		},
		onLoad() {
			// #ifdef APP-PLUS
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
				this.jy_loadInterstitialAd();
				// this.jy_loadAppOpenAD();

				// setTimeout(() => {
				// 	this.jy_loadAppOpenAD();
				// }, 3000)
				// #endif
			}
		},
		methods: {
			jy_loadRewardedAd() {
				var JYGoogleAdMob = uni.requireNativePlugin("JY-GoogleAdMob");
				JYGoogleAdMob.jy_loadRewardedAd({
					adId: "ca-app-pub-5707161891548694/5327817443",
					appId: "ca-app-pub-5707161891548694~8595189944"
				}, res => {
					//  数据格式见上面说明
					console.log(JSON.stringify(res));
					this.jy_showRewardedAd();
					uni.showToast({
						icon: 'none',
						title: JSON.stringify(res)
					})
				});
			},
			jy_showRewardedAd() {
				var jygooglead = uni.requireNativePlugin("JY-GoogleAdMob");
				jygooglead.jy_showRewardedAd({
					//  可以不用传值进去，但是需要配置这项数据
				}, result => {
					//  数据格式见上面说明
					console.log(JSON.stringify(result));
					uni.showToast({
						icon: 'none',
						title: JSON.stringify(result)
					})
				});
			},
			jy_loadAppOpenAD() {
				var jygooglead = uni.requireNativePlugin("JY-GoogleAdMob");
				jygooglead.jy_loadAppOpenAD({
					adId: this.adId
				}, res => { // 数据格式见上面说明 
					uni.showModal({
						title: '提示',
						content: JSON.stringify(res),
						success: function(res) {}
					});
				})
			},

			jy_loadInterstitialAd() {
				this.isInit = true;
				var jygooglead = uni.requireNativePlugin("JY-GoogleAdMob");
				jygooglead.jy_loadInterstitialAd({
						// adId: this.adId
						// adId: "ca-app-pub-3940256099942544/1033173712"
						adId: "ca-app-pub-5707161891548694/4751697400"
					},
					res => {
						console.log(JSON.stringify(res));
						if (res.errorCode == 0) {

							if (res.code == '100') {
								plus.navigator.closeSplashscreen();
								this.jy_showInterstitialAd();
							} else if (res.code == '104') {
								this.addInteger()
							} else if (res.code == '107') {

							} else if (res.code == '106') {
								uni.showToast({
									icon: 'none',
									title: "AD-ERROR"
								})
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
							uni.showToast({
								icon: 'none',
								title: JSON.stringify(res)
							})
						}

					})
			},
			jy_showInterstitialAd() {
				var jygooglead = uni.requireNativePlugin("JY-GoogleAdMob");
				jygooglead.jy_showInterstitialAd({},
					res => {
						console.log(JSON.stringify(res));
						uni.showToast({
							icon: 'none',
							title: JSON.stringify(res)
						})
					})
			},
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