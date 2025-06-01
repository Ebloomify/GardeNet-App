<template>
	<view>
		<view class="box">
			<u-navbar :background="{ background: 'transparent' }" title-color="#fff" back-icon-color="#fff"
				title-size="28" title="Photo recognition"></u-navbar>
			<image src="../../static/images/one.png" mode="widthFix" class="img"></image>
			<view class="h100"></view>
			<view class="flex itc juc">
				<view class="btn mr30" @click="photo('album')">
					<image src="../../static/images/fbtn_05.png" mode="aspectFill" class="btn"></image>
				</view>

				<view class="btn " @click="photo('camera')">
					<image src="../../static/images/fbtn_03.png" mode="aspectFill" class="btn"></image>
				</view>

			</view>
			<view class="p0_60">
				<view class="fz32 cf lh100 mt30">Search Type</view>
				<view class="flex juc itc mb40">


					<view class="list mr30" :class="{'active': type == 'leaf'}" @click="type = 'leaf'">
						<view class="flex juc itc h100">
							<image src="../../static/images/leaf.png" mode="widthFix" class="flower mr20"></image>
							<view class="fz32 cf">leaf</view>
						</view>
					</view>
					<view class="list " :class="{'active': type == 'flower'}" @click="type = 'flower'">
						<view class="flex juc itc h100">
							<image src="../../static/images/flowr.png" mode="widthFix" class="flower mr20"></image>
							<view class="fz32 cf">flower</view>
						</view>
					</view>
				</view>
				<view class="fz30 fw9 cf mb10">Instruction：</view>
				<view class="fz26 cf">
					Step 1: Please choose the plant picture from your picture gallery or take a picture to the plant
					that you want to identify.
					<br>
					Step 2: Chose the type that you use to identify the plant, “Leaf” or “Flower”, and then the system
					will return the answers with the matching possibility (score).

					Remember: This service will charge your 5 reward points.

				</view>
			</view>
		</view>
	</view>
</template>

<script>
	/*
		接口说明：https://my.plantnet.org/usage
		api-key：2b10WLvGcokvuwDQ1Xe4VcLsF
		请求地址：https://my-api.plantnet.org/v2/identify/all
	*/

	var mokeList = {
		"query": {
			"project": "all",
			"images": ["http://39.106.204.232//shopimages/1448371056.jpg"],
			"organs": ["flower"]
		},
		"language": "en",
		"preferedReferential": "the-plant-list",
		"results": [{
			"score": 0.32625213265419006,
			"species": {
				"scientificNameWithoutAuthor": "Camellia japonica",
				"scientificNameAuthorship": "L.",
				"genus": {
					"scientificNameWithoutAuthor": "Camellia",
					"scientificNameAuthorship": ""
				},
				"family": {
					"scientificNameWithoutAuthor": "Theaceae",
					"scientificNameAuthorship": ""
				},
				"commonNames": ["Camellia", "Camellia Albino Botti", "Camellia Don Pedro"]
			},
			"gbif": {
				"id": "3189636"
			}
		}, {
			"score": 0.15573647618293762,
			"species": {
				"scientificNameWithoutAuthor": "Ranunculus asiaticus",
				"scientificNameAuthorship": "L.",
				"genus": {
					"scientificNameWithoutAuthor": "Ranunculus",
					"scientificNameAuthorship": ""
				},
				"family": {
					"scientificNameWithoutAuthor": "Ranunculaceae",
					"scientificNameAuthorship": ""
				},
				"commonNames": ["Persian buttercup", "Persian crowfoot", "Asian buttercup"]
			},
			"gbif": {
				"id": "7721054"
			}
		}, {
			"score": 0.08567388355731964,
			"species": {
				"scientificNameWithoutAuthor": "Tulipa gesneriana",
				"scientificNameAuthorship": "L.",
				"genus": {
					"scientificNameWithoutAuthor": "Tulipa",
					"scientificNameAuthorship": ""
				},
				"family": {
					"scientificNameWithoutAuthor": "Liliaceae",
					"scientificNameAuthorship": ""
				},
				"commonNames": ["Gesner's tulip", "Garden tulip", "Tulip"]
			},
			"gbif": {
				"id": "5299675"
			}
		}, {
			"score": 0.07028577476739883,
			"species": {
				"scientificNameWithoutAuthor": "Rosa chinensis",
				"scientificNameAuthorship": "Jacq.",
				"genus": {
					"scientificNameWithoutAuthor": "Rosa",
					"scientificNameAuthorship": ""
				},
				"family": {
					"scientificNameWithoutAuthor": "Rosaceae",
					"scientificNameAuthorship": ""
				},
				"commonNames": ["Bengal rose", "China rose", "Chinese rose"]
			},
			"gbif": {
				"id": "3005039"
			}
		}, {
			"score": 0.008681894280016422,
			"species": {
				"scientificNameWithoutAuthor": "Eustoma grandiflorum",
				"scientificNameAuthorship": "(Raf.) Shinners",
				"genus": {
					"scientificNameWithoutAuthor": "Eustoma",
					"scientificNameAuthorship": ""
				},
				"family": {
					"scientificNameWithoutAuthor": "Gentianaceae",
					"scientificNameAuthorship": ""
				},
				"commonNames": ["Showy prairie gentian"]
			},
			"gbif": {
				"id": "6366868"
			}
		}, {
			"score": 0.005147675983607769,
			"species": {
				"scientificNameWithoutAuthor": "Impatiens walleriana",
				"scientificNameAuthorship": "Hook.f.",
				"genus": {
					"scientificNameWithoutAuthor": "Impatiens",
					"scientificNameAuthorship": ""
				},
				"family": {
					"scientificNameWithoutAuthor": "Balsaminaceae",
					"scientificNameAuthorship": ""
				},
				"commonNames": ["Busy lizzy", "Busy-Lizzy", "Buzzy lizzy"]
			},
			"gbif": {
				"id": "2891772"
			}
		}],
		"remainingIdentificationRequests": 198
	}

	export default {
		data() {
			return {
				type: 'leaf',
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
			}
		},
		onLoad() {

		},
		methods: {
			//登录
			login() {
				var _userJson = uni.getStorageSync('userJson');
				if (!_userJson) return;
				var datas = {
					email: _userJson.email,
					password: _userJson.password,
					// #ifdef APP-PLUS
					jpushcode: plus.push.getClientInfo() ? plus.push.getClientInfo().clientid : ''
					// #endif
				};
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
			},
			reduce() {

				var datas = {
					type: 2,
					integer: 10,
					integer_dec: "Plant identification"
				};
				this.requestSet.getData(datas, "/V1.PlusMinusInteger/save", 'POST').then((res) => {
					this.login();
					if (res.status == 200) {

					} else {

					};
				}).catch((err) => {
					console.log(err);
				});
			},
			photo(adType) {
				if (this.userInfo.data.integral < 5) {
					this.requestSet.showToast('Insufficient points');
					return;
				};
				var that = this;
				// that.setSearchInfo(mokeList);
				// uni.navigateTo({
				// 	url: "/pages/photo/result?img=/shopimages/1448371056.jpg"
				// })
				// return;
				try {
					uni.chooseImage({
						count: 1, //默认9
						sizeType: ['original', 'compressed'], //可以指定是原图还是压缩图，默认二者都有
						sourceType: [adType], //从相册选择
						success: (chooseImageRes) => {
							const tempFilePaths = chooseImageRes.tempFilePaths;
							uni.showLoading({
								title: 'Loading'
							});
							plus.io.resolveLocalFileSystemURL(tempFilePaths[0], function(entry) {
								// 可通过entry对象操作test.html文件 

								entry.file(function(file) {
									uni.uploadFile({
										url: that.$r.ajaxUrl + '/Base/upload',
										filePath: file.fullPath,
										name: 'file',
										header: {
											Authorization: that.token
										},
										formData: {

										},
										success: (bres) => {
											var res = JSON.parse(bres.data);
											if (res.status == 200) {
												var datas = {
													organs: that.type,
													images: that.url + res.data
												};
												var aurl = res.data;
												uni.showLoading({
													title: 'Loading'
												});
												uni.request({
													url: 'https://my-api.plantnet.org/v2/identify/all?api-key=2b10WLvGcokvuwDQ1Xe4VcLsF', //仅为示例，并非真实接口地址。
													data: datas,
													method: "GET",
													success: (res) => {
														that.setSearchInfo(
															res
															.data);
														uni.navigateTo({
															url: "/pages/photo/result?img=" +
																aurl,
															success: (
																res
															) => {

																that
																	.reduce();
															}
														})
													},
													fail(e) {
														that.requestSet
															.showToast(
																'Error');
													},
													complete() {
														uni.hideLoading();
													}
												});
											} else {
												that.$r.showToast(res.msg)
											}
										},
										error: (err) => {
											console.log(err);
											uni.hideLoading();
											that.requestSet.showToast('fail');
										},
										complete(res) {
											uni.hideLoading();
										}
									});
								});
							}, function(e) {
								uni.hideLoading();
								console.log(e);
							});
						}
					});

				} catch (e) {
					console.log(e);
					//TODO handle the exception
				}

			}
		}
	}
</script>

<style>
	.box {
		background: url(../../static/images/fbg.jpg) no-repeat bottom left;
		background-size: cover;
		height: 100vh;
	}

	.img {
		width: 100%;
		margin-top: 20vh;
	}

	.btn {
		width: 319rpx;
		height: 99rpx;
	}


	.p0_60 {
		padding: 0 60rpx;
	}

	.flower {
		width: 60rpx;
	}

	.list {
		width: 300rpx;
		border: 4rpx solid #fff;
		border-radius: 10rpx;
	}

	.active {
		background-color: #48cfb2;
	}
</style>
