<template>
	<view>
		<view class="p30">
			<button class="mb20" @click="jy_loadInterstitialAd">插屏广告</button>
			<button class="mb20" @click="jy_loadAppOpenAD">开屏广告</button>
			<button @click="jy_loadRewardedAd">激励广告</button>
		</view>
	</view>
</template>

<script>
	const JYGoogleAdMob = uni.requireNativePlugin('JY-GoogleAdMob');
	export default {
		data() {
			return {

			}
		},
		onLoad() {
			this.jy_init();
			this.getLocation();
		},
		methods: {
			getLocation() {
				uni.getLocation({
					type: 'wgs84',
					success: function (res) {
						console.log('当前位置的经度：' + res.longitude);
						console.log('当前位置的纬度：' + res.latitude);
					}
				});

			},
			jy_init() {
				//  此方法必须调用，否则可能出现异常！！
				JYGoogleAdMob.jy_init();
			},
			// 加载激励视频
			jy_loadRewardedAd() {
				this.showLoading();
				JYGoogleAdMob.jy_loadRewardedAd({
					adId: 'ca-app-pub-5707161891548694/5327817443',
					appId: 'ca-app-pub-5707161891548694~8595189944'
				}, res => {
					//  数据格式见上面说明
					this.hideLoading()
					console.log(JSON.stringify(res));
					 /*
						res.errorCode == 0 广告请求成功  
								∨∨∨∨∨∨∨∨
						res.code == '100'广告加载成功
					 */ 
					uni.showModal({
						title: '提示',
						content: JSON.stringify(res),
						success: function (res) {
							if (res.confirm) {
								console.log('用户点击确定');
							} else if (res.cancel) {
								console.log('用户点击取消');
							}
						}
					});
				});
			},
			//显示激励视频 
			jy_showRewardedAd() {
				JYGoogleAdMob.jy_showRewardedAd({
					//  可以不用传值进去，但是需要配置这项数据
				}, result => {
					//  数据格式见上面说明
					console.log(JSON.stringify(res));
					uni.showToast({
						icon: 'none',
						title: JSON.stringify(res)
					})
				});
			},
			//加载插屏广告
			jy_loadInterstitialAd() {
				this.showLoading();
				var JYGoogleAdMob = uni.requireNativePlugin("JY-GoogleAdMob");
				JYGoogleAdMob.jy_loadInterstitialAd({
						// adId: "ca-app-pub-3940256099942544/1033173712" // testID
						adId: "ca-app-pub-5707161891548694/9403166005"
					},
					res => {
						//  数据格式见上面说明
						console.log(JSON.stringify(res));
						this.hideLoading()
						if(res.errorCode == 0 && res.code == '100') {
							this.jy_showInterstitialAd();
						} else {
							uni.showModal({
								title: '提示',
								content: JSON.stringify(res),
								success: function (res) {
									if (res.confirm) {
										console.log('用户点击确定');
									} else if (res.cancel) {
										console.log('用户点击取消');
									}
								}
							});
						}
						
					})
			},
			//显示插屏广告
			jy_showInterstitialAd() {
				var JYGoogleAdMob = uni.requireNativePlugin("JY-GoogleAdMob");
				JYGoogleAdMob.jy_showInterstitialAd({

					},
					res => {
						//  数据格式见上面说明
						console.log(JSON.stringify(res));
						uni.showToast({
							icon: 'none',
							title: JSON.stringify(res)
						})
					})
			},
			// 加载开屏广告
			jy_loadAppOpenAD() {
				this.showLoading();
				var JYGoogleAdMob = uni.requireNativePlugin("JY-GoogleAdMob");
				JYGoogleAdMob.jy_loadAppOpenAD({
					// adId: "ca-app-pub-3940256099942544/9257395921" // testID
					adId: "ca-app-pub-5707161891548694/5812051844"
				}, res => { // 数据格式见上面说明
					console.log(JSON.stringify(res));
					this.hideLoading()
					uni.showModal({
						title: '提示',
						content: JSON.stringify(res),
						success: function (res) {
							if (res.confirm) {
								console.log('用户点击确定');
							} else if (res.cancel) {
								console.log('用户点击取消');
							}
						}
					});
				})
			},
			// 显示开屏广告
			jy_showAppOpenAD() {
				var JYGoogleAdMob = uni.requireNativePlugin("JY-GoogleAdMob");
				JYGoogleAdMob.jy_showAppOpenAD({

				}, res => { // 数据格式见上面说明 
					console.log(JSON.stringify(res));
					uni.showToast({
						icon: 'none',
						title: JSON.stringify(res)
					})
				})
			},
			showLoading() {
				uni.showLoading({
					mask: true,
					title: "广告加载中"
				})
			},
			hideLoading() {
				uni.hideLoading();
			}

		}
	}
</script>

<style>

</style>