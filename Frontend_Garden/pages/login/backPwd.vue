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
			<view class="flex itc juc bb1 h100">
				<view style="width: 90rpx;" class="tac">
					<view class="iconmima fz40 c6"></view>
				</view>
				<view class="flex_1">
					<input maxlength="-1"  type="number" class="w100 fz32 c3" placeholder="Verification Code" v-model="code">
				</view>
				<view class="code" :class="{'disabled':codeDisabled}" @click="getCode">{{codeName}}</view>
			</view>
			<!--  -->
			<view class="flex itc juc bb1 h100">
				<view style="width: 90rpx;" class="tac">
					<view class="iconmima fz40 c6"></view>
				</view>
				<view class="flex_1">
					<input maxlength="-1"  :password="true" class="w100 fz32 c3" placeholder="Password" v-model="password">
				</view>
			</view>
			<!--  -->
			<view class="flex itc juc bb1 h100">
				<view style="width: 90rpx;" class="tac">
					<view class="iconmima fz40 c6"></view>
				</view>
				<view class="flex_1">
					<input maxlength="-1"  :password="true" class="w100 fz32 c3" placeholder="Comfirm password" v-model="rePassword">
				</view>
			</view>

			<view class="h40"></view>
			<view class="">
				<u-button type="primary" clas="btn h100 " :custom-style="customStyle" :ripple="true"
					:disabled="disabled" @click="submit">Submit</u-button>
			</view>
		</view>

	</view>
</template>

<script>
	var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	var time = 120,
		timer;
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
				code: "",
				password: "",
				rePassword: "",
				codeDisabled: false,
				codeName: "Send Code",
				backCode: ""
			}
		},
		methods: {
			getCode() {
				if (this.codeDisabled) {
					return;
				};
				if (!myreg.test(this.phone)) {
					this.requestSet.showToast('Email address error');
					return;
				};
				this.codeDisabled = true;
				var datas = {
					email: this.phone
				};
				this.requestSet.getData(datas, '/Base/emailCode', 'POST').then((res) => {
					uni.hideLoading();
					if (res.status == 200) {
						this.requestSet.showToast('Success');
						var timer = setInterval(() => {
							if (time == 1) {
								clearInterval(timer);
								this.codeName = 'Send Code';
								this.codeDisabled = false;
								time = 120;
							} else {
								time--;
								this.codeName = time;
							}
						}, 1000);
					} else {
						this.codeDisabled = false;
						this.requestSet.showToast(res.msg);
					};
					this.isMark = false;
				}).catch((err) => {
					this.codeDisabled = false;
				});

			},
			submit() {
				if (this.disabled) {
					return;
				};
				if (!myreg.test(this.phone)) {
					this.requestSet.showToast('Please enter the correct email');
					return;
				};
				// if (!this.code || this.code != this.backCode) {
				// 	this.requestSet.showToast('Verification code error');
				// 	return;
				// }
				if (!this.code) {
					this.requestSet.showToast('Verification code error');
					return;
				}
				if (!this.password || this.password.length < 6) {
					this.requestSet.showToast('Please input a password');
					return;
				}
				if (this.rePassword !== this.password) {
					this.requestSet.showToast('The two passwords are inconsistent');
					return;
				}
				uni.showLoading({
					title: 'Loading',
					mark: true,

				})
				this.disabled = true;
				var datas = {
					email: this.phone,
					code: this.code,
					password: this.password,
					re_password: this.rePassword,
				};
				this.requestSet.getData(datas, '/V1.Member/resetPassword', 'post').then((res) => {
					if (res.status == 200) {
						// 缓存登录信息
						uni.setStorageSync('userJson', datas);
						this.requestSet.showToast('success');
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

	.code {
		width: 180rpx;
		line-height: 50rpx;
		border-radius: 25rpx;
		background-image: linear-gradient(to right, #52d0bb, #48d39a);
		text-align: center;
		color: #fff;
		font-size: 24rpx;
	}

	.disabled {
		background-color: #ededed;
		background-image: inherit;
	}
</style>
