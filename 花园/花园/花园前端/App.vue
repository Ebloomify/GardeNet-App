<script>
	/*
	
		p40 cid:5162e550bda6da3ffe07eabe5ee84ecd
		p40 cid:1ed26fd7e54f1121b8b79acfe4521458
	*/
	// 推送相关
	var _title, _msg, _isOpenBanner;

	var isTapCenter;
	var g_wakelock = null;
	var i = 0;
	var JYGoogleAdMob = uni.requireNativePlugin("JY-GoogleAdMob");
	import push from 'js_sdk/push/push.js';
	export default {
		data() {
			return {

			}
		},
		onLaunch: function() {
			
			// 监听点击中间按钮
			this.centerBtn();
			// 静默登录
			this.login();
			// 推送消息
			push.init();
			// 获取cid
			push.getClient()
			// 65e2574b8ed4b9627ed683228d1ec096
			uni.$on("jifenRefresh", () => {
				this.login();
			})
			plus.navigator.closeSplashscreen();
			// 判断并提示获取通知权限
			// this.$r.setPermissions();

		},
		onShow: function() {
			// console.log('App Show')
		},
		onHide: function() {
			// console.log('App Hide')
		},
		methods: {

			getFeStatus() { //获取推荐栏目开关状态

			},
			//点击中间按钮
			centerBtn() {
				uni.onTabBarMidButtonTap(() => {
					if (isTapCenter) {
						return;
					}
					isTapCenter = true;
					if (!this.userInfo || !this.token) {
						uni.navigateTo({
							url: "/pages/login/login"
						})
					} else {
						uni.navigateTo({
							url: "/pages/add/add"
						})

					}
					isTapCenter = false;
				})
			},
			login() {
				var _userJson = uni.getStorageSync('userJson');
				console.log(_userJson)
				if (!_userJson) return;
				var datas = {
					email: _userJson.email,
					password: _userJson.password,
					// #ifdef APP-PLUS
					client_id: plus.push.getClientInfo() ? plus.push.getClientInfo().clientid : ''
					// #endif
				};
				console.log(datas)
				this.requestSet.getData(datas, '/V1.Member/emailLogin', 'POST').then((res) => {
					if (res.status == 200) {
						// 保存用户信息
						this.setUserInfo(res);
						//保存用户token
						this.setToken(res.token);
					} else {
						this.requestSet.showToast(res.msg);
						// 清除登录信息
						uni.removeStorageSync('userJson');
						// 清除用户信息
						uni.removeStorageSync('userInfo');
						// 清空store用户信息
						this.setUserInfo({});
						// 清空store Token信息
						this.setToken('');
					};
				}).catch((err) => {
					console.log(err)
					this.disabled = false;
				});
			}
		}
	}
</script>

<style>
	@import url("/static/css/public.css");
	@import url("/static/fonts/iconfont.css");

	/*每个页面公共css */
	.ca {
		color: #48cfb2;
	}

	.bga {
		background: #48cfb2;
	}

	.green {
		color: #3d951b;
	}

	.blue {
		color: #4891e6;
	}

	.bor20 {
		border-radius: 20rpx;
	}

	.boxSha {
		box-shadow: 0 0 10rpx #ddd;
	}

	.red {
		color: #f57474;
	}

	/* 级别 */
	.l1 {
		height: 34rpx;
		width: 87rpx;
	}

	.l2 {
		height: 34rpx;
		width: 87rpx;
	}

	.l3 {
		height: 34rpx;
		width: 87rpx;
	}

	.l4 {
		height: 34rpx;
		width: 87rpx;
	}

	.l5 {
		height: 34rpx;
		width: 87rpx;
	}

	.l6 {
		height: 34rpx;
		width: 87rpx;
	}

	.l7 {
		height: 34rpx;
		width: 87rpx;
	}

	.l8 {
		height: 34rpx;
		width: 87rpx;
	}

	.l9 {
		height: 34rpx;
		width: 87rpx;
	}

	.l10 {
		height: 34rpx;
		width: 98rpx;
	}

	.l11 {
		height: 34rpx;
		width: 98rpx;
	}

	.l12 {
		height: 34rpx;
		width: 98rpx;
	}

	.l13 {
		height: 34rpx;
		width: 98rpx;
	}

	.l14 {
		height: 34rpx;
		width: 98rpx;
	}

	.l15 {
		height: 34rpx;
		width: 98rpx;
	}

	.l16 {
		height: 34rpx;
		width: 98rpx;
	}

	.l17 {
		height: 34rpx;
		width: 98rpx;
	}

	.l18 {
		height: 34rpx;
		width: 98rpx;
	}

	.l19 {
		height: 34rpx;
		width: 98rpx;
	}
</style>