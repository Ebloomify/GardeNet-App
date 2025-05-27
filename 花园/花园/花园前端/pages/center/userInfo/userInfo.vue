<template>
	<view>
		<view class="p0_30">
			<view class="flex itc bb1 h110">
				<view class="flex_1">
					<view class="fz30 c3">Head Image</view>
				</view>
				<view class="avt">
					<image :src="url+ avatar" mode="" class="avt_img" @tap="chooseAvatar"></image>
				</view>
			</view>
			<view class="flex itc bb1 h110">
				<view class="">
					<view class="fz30 c3">Nickname</view>
				</view>
				<view class="flex_1">
					<input maxlength="-1"  type="text" class="tar fz30 c3 w100" v-model="name">
				</view>
			</view>
		</view>
		<view class="h10 bgf4"></view>
		<view class="p0_30">
			<view class="flex itc bb1 h110">
				<view class="">
					<view class="fz30 c3">Email</view>
				</view>
				<view class="flex_1">
					<input maxlength="-1"  type="text" class="tar fz30 c3 w100" :placeholder="userInfo.data.email" disabled="true">
				</view>
			</view>
			<view class="flex itc bb1 h110">
				<view class="flex_1">
					<view class="fz30 c3">Gender</view>
				</view>
				<!-- {{sex == '1' ? 'male' : 'famale'}} -->
				<view class="mr20">
					<view class="flex itc" @click="sex = 1">
						<view class="yuan  mr20" :class="{'active': sex == 1}">
							<view class=""></view>
						</view>
						<view class="fz26 c9">male</view>
					</view>
				</view>
				<view class="">
					<view class="flex itc" @click="sex = 2">
						<view class="yuan mr20" :class="{'active': sex == 2}">
							<view class=""></view>
						</view>
						<view class="fz26 c9">female</view>
					</view>
				</view>
			</view>
			<view class="p30_0 flex itc bb1">
				<view class="">
					<view class="fz30 c3">Mobile phone no</view>
					<view class="fz20 c9">
						help keep GaedeNet and your account protected
						please add yourr phone number
					</view>
				</view>
				<view class="">
					<input maxlength="-1"  type="text" class="tar fz30 c3 w100" style="width: 200rpx;" placeholder="phone number"
						v-model="phone">
				</view>
			</view>
			<!--  -->
			<view class="flex itc bb1 h110" @click="show = true">
				<view class="flex_1">
					<view class="fz30 c3">Region</view>
				</view>
				<view class="fz26 c9 mr20">{{ region ? region : 'Please select'}}</view>
				<view class="c9 iconarrow-right-copy-copy"></view>
			</view>
			<!--  -->
			<view class="fz30 c3 lh80">What's up</view>
			<view class="p20 bgf4 bor10">
				<textarea maxlength="-1" class="" placeholder="Tell something about yourself" v-model="desc"></textarea>
			</view>
			<view class="h50"></view>
			<view class="">
				<u-button type="primary" clas="btn h100 " :custom-style="customStyle" :ripple="true"
					:disabled="disabled" @click="submit">submit</u-button>
			</view>
			<view class="h50"></view>
		</view>
		<!--  -->
		<u-select v-model="show" :list="list" @confirm="confirm"></u-select>
	</view>
</template>

<script>
	import cityData from './city.js';
	export default {
		data() {
			return {
				avatar: "",
				name: "",
				phone: "",
				sex: 0, //性别 1 = 男  2 = 女
				region: "", //城市信息
				desc: "", //签名
				disabled: false,
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				customStyle: {
					height: "80rpx",
					borderRadius: "40rpx",
					backgroundImage: "linear-gradient(to right, #52d0bb, #48d39a)"
				},
				show: false,
				list: cityData, //城市信息列表
			}
		},
		onLoad() {
			this.avatar = this.userInfo.data.avatar;
			this.name = this.userInfo.data.nickname;
			this.phone = this.userInfo.data.mobile;
			this.sex = this.userInfo.data.sex;
			this.region = this.userInfo.data.area;
			this.desc = this.userInfo.data.human_desc;
			var _this = this;
			uni.$on('uAvatarCropper', path => {
				// this.avatar = path;
				// 可以在此上传到服务端
				uni.showLoading({
					mask: true,
					title: "Loading"
				})
				plus.io.resolveLocalFileSystemURL(path, function(entry) {
					// 可通过entry对象操作test.html文件 
					entry.file(function(file) {
						uni.uploadFile({
							url: _this.$r.ajaxUrl + '/Base/upload',
							filePath: file.fullPath,
							name: 'file',
							header: {
								Authorization: _this.token
							},
							formData: {
						
							},
							success: (res) => {
								var datas = JSON.parse(res.data);
								if (datas.status == 200) {
									_this.avatar = datas.data;
								} else {
									_this.$r.showToast(datas.msg)
								}
							},
							error: (err) => {
								_this.requestSet.showToast('fail');
							},
							complete(res) {
							}
						});
					});
				}, function(e) {
					console.log(e);
				});
			});
		},
		onUnload() {
			uni.$off('uAvatarCropper')
		},
		methods: {
			// 选择地区
			confirm(e) {
				this.region = e[0].label;
			},
			submit() {
				if (this.disabled) return;
				if (!this.name) {
					this.requestSet.showToast('Please enter a Nickname');
					return;
				};
				if (this.name.length > 20) {
					this.requestSet.showToast('The Nickname cannot exceed 20 characters');
					return;
				};
				var datas = {
					member_id: this.userInfo.data.member_id,
					nickname: this.name,
					avatar: this.avatar,
					sex: this.sex,
					area: this.region,
					address: '',
					human_desc: this.desc,
					mobile: this.phone,

				};
				this.disabled = true;
				this.requestSet.getData(datas, '/V1.Member/update', 'POST').then((res) => {
					if (res.status == 200) {
						this.login();
					} else {
						this.disabled = false;
						this.requestSet.showToast(res.msg);
					};
				}).catch((err) => {
					this.disabled = false;
				});
			},

			chooseAvatar() {
				// 此为uView的跳转方法，详见"文档-JS"部分，也可以用uni的uni.navigateTo
				this.$u.route({
					// 关于此路径，请见下方"注意事项"
					url: '/uview-ui/components/u-avatar-cropper/u-avatar-cropper',
					// 内部已设置以下默认参数值，可不传这些参数
					params: {
						// 输出图片宽度，高等于宽，单位px
						destWidth: 300,
						// 裁剪框宽度，高等于宽，单位px
						rectWidth: 200,
						// 输出的图片类型，如果'png'类型发现裁剪的图片太大，改成"jpg"即可
						fileType: 'jpg',
					}
				})
			},
			//登录
			login() {
				var _userJson = uni.getStorageSync('userJson');
				if (!_userJson.email || !_userJson.password) return;
				var datas = {
					email: _userJson.email,
					password: _userJson.password
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
	.avt_img {
		width: 80rpx;
		height: 80rpx;
		border-radius: 50%;
		display: block;
	}

	.h110 {
		height: 110rpx;
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
