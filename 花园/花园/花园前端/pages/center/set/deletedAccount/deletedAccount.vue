<template>
	<view>
		<view class="bgf p30">
			<view class="fz30 c6 mb20">Please enter your email or phone number to get verification code</view>
			<view class="flex  itc h100 ">
				<input maxlength="-1" type="number" class="w100 flex_1 mr20 fz30 c3"
					placeholder="Enter Veification Code" v-model="code">
				<view class="codeBtn" :class="{'disabled':codeDisabled}" @click="getCode">{{codeName}}</view>
			</view>
		</view>
		<view class="fz24 fw9 p0_30 red">* Deleting an account cannot be retrieved. Please proceed with caution.</view>
		<view class="h50"></view>
		<view class="p30">
			<u-button type="primary" clas="btn h100 " :custom-style="customStyle" :ripple="true" :disabled="disabled"
				@click="submit">deletedAccount</u-button>
		</view>
	</view>
</template>

<script>
	var time = 60,
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
				code: "",
				password: "",
				rePassword: "",
				codeDisabled: false,
				codeName: "code",
				backCode: ""
			}
		},
		methods: {
			getCode() {
				if (this.codeDisabled) {
					return;
				};
				this.codeDisabled = true;
				var datas = {
					email: this.userInfo.data.email
				};
				this.requestSet.getData(datas, '/Base/emailCode', 'POST').then((res) => {
					uni.hideLoading();
					if (res.status == 200) {
						this.requestSet.showToast('Success');
						var timer = setInterval(() => {
							if (time == 1) {
								clearInterval(timer);
								this.codeName = 'code';
								this.codeDisabled = false;
								time = 60;
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
				if (!this.code) {
					this.requestSet.showToast('Verification code error');
					return;
				}
				uni.showModal({
					title: 'Tips',
					content: 'Are you sure to delete the account? It cannot be retrieved after deletion.',
					confirmText: "Sure",
					cancelText: "cancel",
					success: (res) => {
						if (res.confirm) {
							this.deletedAccountFn();
						}
					}
				});


			},
			deletedAccountFn() {
				uni.showLoading({
					title: 'Loading',
					mark: true
				})
				this.disabled = true;
				var datas = {
					email: this.userInfo.data.email,
					code: this.code,
					member_id: this.userInfo.data.member_id
				};
				this.requestSet.getData(datas, '/V1.Member/logout', 'POST').then((res) => {
					if (res.status == 200) {
						uni.showModal({
							title: 'Tips',
							content: 'Successfully deleted account',
							confirmText: "OK",
							showCancel: false,
							success: (res) => {
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
						});

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
	page {
		background-color: #f7f7f7;
	}

	.codeBtn {
		background: linear-gradient(to right, #48cfb0, #48d39d);
		width: 150rpx;
		line-height: 52rpx;
		border-radius: 26rpx;
		text-align: center;
		font-size: 28rpx;
		color: #fff;
	}

	.disabled {
		background-color: #ededed;
		background-image: inherit;
	}
</style>