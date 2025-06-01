<template>
	<view>
		<image src="../../static/images/login.jpg" mode="widthFix" style="width: 100%;"></image>
		<view class="login_box tac p20_0">
			<image src="../../static/images/logo.png" mode=""></image>
			<view class="fz40 c3 tac fw9 mt10">MY GardeNet</view>
		</view>
		<view class="h40"></view>
		<!--  -->
		<view class="list_box">
			<view class="flex itc juc bb1 h100">
				<view style="width: 90rpx;" class="tac">
					<view class="iconzhanghu fz40 c6"></view>
				</view>
				<view class="flex_1">
					<input maxlength="-1"  type="text" class="w100 fz32 c3" placeholder="Email" v-model="phone">
				</view>
			</view>
			<!--  -->
			<view class="h40"></view>
			<view class="flex itc juc bb1 h100">
				<view style="width: 90rpx;" class="tac">
					<view class="iconmima fz40 c6"></view>
				</view>
				<view class="flex_1">
					<input maxlength="-1"  :password="true" class="w100 fz32 c3" placeholder="Password" v-model="password">
				</view>
			</view>
			<!--  -->
			<view class="flex itc h90">
				<view class="flex_1">
					<view class="ca fz24">
						<navigator url="/pages/login/backPwd">Forgot password</navigator>
					</view>
				</view>
				<view class="flex_1">
					<view class="c9 fz24 tar">
						<navigator url="/pages/login/register">Register</navigator>
					</view>
				</view>
			</view>
			<view class="h40"></view>
			<view class="">
				<u-button type="primary" clas="btn h100 " :custom-style="customStyle" :ripple="true"
					:disabled="disabled" @click="submit">Login</u-button>
			</view>
			<view class="h40"></view>
			<!-- <view class="fz24 c9 tac" @click="nav('/pages/rule/rule?keyword=rule')">登录即表示同意<text class="ca">《隐私政策》</text>和<text
				 class="ca">《服务协议》</text></view> -->
			<view class="fz24 c9 tac">your login means you are content to
				<text class="ca" @click="nav('/pages/rule/rule?keyword=rule1')">《accept Privacy policy》</text>
				and
				<text class="ca" @click="nav('/pages/rule/rule?keyword=rule2')">《Service policy》</text>
			</view>
		</view>

	</view>
</template>

<script>
	var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	export default {
		data() {
			return {
				disabled: false,
				customStyle: {
					height: "80rpx",
					borderRadius: "40rpx",
					backgroundImage: "linear-gradient(to right, #52d0bb, #48d39a)"
				},
				phone: "",
				password: ""
			}
		},
		onLoad() {
			var _userJson = uni.getStorageSync('userJson');
			this.phone = _userJson.email;
		},
		methods: {
			nav(url) {
				uni.navigateTo({
					url: url
				})
			},
			submit() {
				if (this.disabled) {
					return;
				};
				// if (!myreg.test(this.phone)) {
				// 	this.requestSet.showToast('Please enter the correct email');
				// 	return;
				// };
				if (!this.password || this.password.length < 6) {
					this.requestSet.showToast('Please input a password');
					return;
				}
				uni.showLoading({
					title: 'Loading',
					mark: true
				})
				this.disabled = true;
				var datas = {
					email: this.phone,
					password: this.password,
					// #ifdef APP-PLUS
					client_id: plus.push.getClientInfo() ? plus.push.getClientInfo().clientid : ''
					// #endif
				};
				this.requestSet.getData(datas, '/V1.Member/emailLogin', 'POST').then((res) => {
					if (res.status == 200) {
						// 保存用户信息
						this.setUserInfo(res);
						//保存用户token
						this.setToken(res.token);
						// 缓存登录信息
						uni.setStorageSync('userJson', datas);
						this.requestSet.showToast('success');
						uni.$emit('refreshCenter');
						setTimeout(() => {
							uni.navigateBack({
								delta: 1
							})
						}, 1000)
					} else {
						this.disabled = false;
						this.requestSet.showToast(res.msg);
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
	.login_box image {
		width: 90rpx;
		height: 90rpx;
	}

	.p20_0 {
		padding: 20rpx 0;
	}

	.list_box {
		padding: 0 80rpx;
	}

</style>

