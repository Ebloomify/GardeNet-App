<template>
	<view>
		<view class="p0_30">
			<!-- 修改个人信息 -->
			<view class="flex itc bb1 h110" @click="nav('/pages/center/userInfo/userInfo')">
				<view class="flex_1">
					<view class="fz30 c3">Edit my profile</view>
				</view>
				<view class="c9 iconarrow-right-copy-copy"></view>
			</view>
			<!-- 修改密码 -->
			<view class="flex itc bb1 h110" @click="nav('/pages/center/set/editPassword/editPassword')">
				<view class="flex_1">
					<view class="fz30 c3">Change Password</view>
				</view>
				<view class="c9 iconarrow-right-copy-copy"></view>
			</view>
		</view>
		<view class="h10 bgf4"></view>
		<view class="p0_30">
			<!-- 缓存 -->
			<view class="flex itc bb1 h110" @click="clearCache()">
				<view class="flex_1">
					<view class="fz30 c3">Clear the cache </view>
				</view>
				<view class="fz28 c9">
					{{cacheSize}}MB
				</view>
			</view>
			<!-- 设置花园是否可以查看 -->
			<!-- <view class="flex itc bb1 h110">
				<view class="flex_1">
					<view class="fz30 c3">Make My Garden Public</view>
				</view>
				<view class="fz28 c9">
					<u-switch v-model="checked" size="40" active-color="#48cfb2" @change="change"></u-switch>
				</view>
			</view> -->
			<!-- 反馈和建议 -->
			<view class="flex itc bb1 h110" @click="nav('/pages/center/set/feedback/feedback')">
				<view class="flex_1">
					<view class="fz30 c3">Feedback and Suggestions</view>
				</view>
				<view class="c9 iconarrow-right-copy-copy"></view>
			</view>
			<!-- 用户协议和隐私条款 -->
			<view class="flex itc bb1 h110" @click="nav('/pages/rule/rule?keyword=rule1')">
				<view class="flex_1">
					<view class="fz30 c3">Privacy policy</view>
				</view>
				<view class="c9 iconarrow-right-copy-copy"></view>
			</view>
			<view class="flex itc bb1 h110" @click="nav('/pages/rule/rule?keyword=rule2')">
				<view class="flex_1">
					<view class="fz30 c3">Service policy</view>
				</view>
				<view class="c9 iconarrow-right-copy-copy"></view>
			</view>
			<!-- 版本信息 -->
			<view class="flex itc bb1 h110">
				<view class="flex_1">
					<view class="fz30 c3">GaedeNet Version</view>
				</view>
				<view class="fz28 c9">
					{{wgtVersion.version || '1.0.0'}}
				</view>
			</view>
			<!-- 关于我们 -->
			<view class="flex itc bb1 h110" @click="nav('/pages/center/set/about/about?keyword=about')">
				<view class="flex_1">
					<view class="fz30 c3">About the GardeNet</view>
				</view>
				<view class="c9 iconarrow-right-copy-copy"></view>
			</view>
			<!-- 注销账户 -->
			<view class="flex itc bb1 h110" @click="nav('/pages/center/set/deletedAccount/deletedAccount')">
				<view class="flex_1">
					<view class="fz30 c3">Account deleted</view>
				</view>
				<view class="c9 iconarrow-right-copy-copy"></view>
			</view>
			<view class="h50"></view>
			<view class="">
				<u-button type="primary" clas="btn h100 " :custom-style="customStyle" :ripple="true" :disabled="disabled" @click="out">Log
					out</u-button>
			</view>
			<view class="h50"></view>
		</view>
	</view>
</template>

<script>
	import {
		resolveFile,
		getDirSize,
		removeDir,
		formatSize
	} from '@/components/img-cache/index.js';
	export default {
		data() {
			return {
				checked: false,
				disabled: false,
				customStyle: {
					height: "80rpx",
					borderRadius: "40rpx",
					backgroundImage: "linear-gradient(to right, #52d0bb, #48d39a)"
				},
				wgtVersion: {}, //增量更新版本
				cacheSize: 0,
			}
		},
		onLoad() {
			this.checked = this.userInfo.member.Publish == 0 ? true : false;
			console.log(this.checked)
			this.wgtVersion = uni.getStorageSync('widgetInfo');
			// #ifdef APP-PLUS
			this.getCache();
			// #endif
		},
		methods: {
			// 退出
			out() {
				uni.showModal({
					title: 'Tips',
					content: 'Are you sure you want to exit',
					confirmText: "Sure",
					cancelText: "cancel",
					success: (res) => {
						if (res.confirm) {
							this.setUserInfo({});
							this.setToken(null);
							uni.removeStorageSync('userInfo');
							uni.removeStorageSync('token');
							uni.removeStorageSync('userJson');
							uni.removeStorageSync('phone');
							uni.reLaunch({
								url: "/pages/index/index"
							})
						}
					}
				});
			},
			change(e){
				// console.log(this.userInfo.logintoken.tokenstr)
				var datas = {
					apipage: "main",
					op: "publish",
					tokenstr: this.userInfo.logintoken.tokenstr,
					Publish: e ? 0 : 1
				}
				this.requestSet.getData(datas, 'api.aspx', 'POST').then((res) => {
					if (res.error == 0) {
						var _userInfo = this.userInfo;
						_userInfo.member.Publish = e ? 0 : 1;
						console.log(_userInfo)
						this.setUserInfo({..._userInfo})
					} else {
						this.disabled = false;
						this.requestSet.showToast(res.returnstr);
					};
				}).catch((err) => {
					this.disabled = false;
				});
			},
			clearCache() {
				uni.showLoading({
					title: 'Loading',
					mask: true
				})
				removeDir('_doc/imgcache').then((res)=> {
					console.log(res);
				});
				plus.cache.clear(()=> {
					setTimeout(()=> {
						uni.hideLoading();
						this.cacheSize = 0;
					}, 500);
				});
			},
			getCache() { //获取缓存大小
				getDirSize('_doc').then((res) => {
					plus.cache.calculate((size) => {
						this.cacheSize = ((size + res) / 1024 / 1024).toFixed(0);
					});
				})
			},
			nav(url) {
				// if (!this.userInfo) return;
				uni.navigateTo({
					url: url
				});
				
				
			}
			
		}
	}
</script>

<style>
	.avt_img {
		width: 80rpx;
		height: 80rpx;
		border-radius: 50%;
		display: block;
	}

	.h110 {
		height: 100rpx;
	}

	.yuan {
		width: 20rpx;
		height: 20rpx;
		border-radius: 50%;
		border: 4rpx solid #000000;
	}

	.active view {
		border-radius: 50%;
		background-color: #48ceb7;
		width: 100%;
		height: 100%;
	}

	.p30_0 {
		padding: 20rpx 0;
	}
</style>
