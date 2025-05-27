<template>
	<view>

	</view>
</template>

<script>
	export default {
		data() {
			return {
				isInit: false,
				iOSAdId: "ca-app-pub-5707161891548694/7981178161", // 苹果
				iOSAppId: "ca-app-pub-5707161891548694~2406680372",
				AndroidAdId: "ca-app-pub-5707161891548694/5327817443", // 安卓
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
				this.jy_loadRewardedAd();
				// #endif
			}
		},
		methods: {
			jy_loadRewardedAd() {
				var JYGoogleAdMob = uni.requireNativePlugin("JY-GoogleAdMob");
				JYGoogleAdMob.jy_loadRewardedAd({
					adId: this.systemInfo.platform === 'android' ? this.AndroidAdId : this.iOSAdId,
					appId:  this.systemInfo.platform === 'android' ? this.AndroidAppId : this.iOSAppId,
					// adId: "ca-app-pub-5707161891548694/5327817443",
					// appId: "ca-app-pub-5707161891548694~8595189944"
				}, res => {
					//  数据格式见上面说明
					console.log(JSON.stringify(res));
					plus.navigator.closeSplashscreen();
					if (res.errorCode == 0) {
					
						if (res.code == '100') {
							
							this.jy_showRewardedAd();
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
							title: "AD-ERROR"
						})
						uni.reLaunch({
							url: '/pages/index/index'
						});
					}
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