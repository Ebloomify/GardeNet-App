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
				<view class="flex juc itc">


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
			reduce() {
				var datas = {
					apipage: "usejifen",
					price: '5',
					tokenstr: this.token
				};
				this.requestSet.getData(datas, 'api.aspx', 'GET').then((res) => {
					if (res.error == 0) {
						this.info = res.data;
					}
					console.log('减积分')
					console.log(res)

				}).catch((err) => {
					console.log(err)
					// this.isMark = true;
					// this.markType = 2;
				});
			},
			photo(adType) {
				if (this.userInfo.member_jifen < 5) {
					this.requestSet.showToast('Insufficient points');
					return;
				};
				var that = this;
				// that.setSearchInfo(mokeList);
				// uni.navigateTo({
				// 	url: "/pages/photo/result?img=/shopimages/1448371056.jpg"
				// })
				// return;
				uni.chooseImage({
					count: 1, //默认9
					sizeType: ['original', 'compressed'], //可以指定是原图还是压缩图，默认二者都有
					sourceType: [adType], //从相册选择
					success: (chooseImageRes) => {
						const tempFilePaths = chooseImageRes.tempFilePaths;
						uni.showLoading({
							title: 'Loading'
						});
						uni.uploadFile({
							url: 'http://39.106.204.232/api.aspx',
							filePath: tempFilePaths[0],
							name: 'upfile',
							formData: {
								apipage: 'fileup'
							},
							success(res) {

								var backDatas = JSON.parse(res.data);
								if (backDatas.error == 0) {
									// this.avatar = backDatas.url;
									var datas = {
										organs: that.type,
										images: that.url + backDatas.url
									};
									// console.log(datas)
									uni.request({
										url: 'https://my-api.plantnet.org/v2/identify/all?api-key=2b10WLvGcokvuwDQ1Xe4VcLsF', //仅为示例，并非真实接口地址。
										data: datas,
										method: "GET",
										success: (res) => {
											// console.log(res.data);
											that.setSearchInfo(res.data);
											uni.navigateTo({
												url: "/pages/photo/result?img=" +
													backDatas.url,
												success: (res) => {
													var _res = that.userInfo;
													_res.member_jifen -= 5;
													that.setUserInfo(_res);
													that.reduce();
												}
											})
										},
										fail(e) {
											console.log(e);
											that.requestSet.showToast('Error');
										},
										complete() {
											uni.hideLoading();
										}
									});
								} else {
									that.requestSet.showToast('fail');
								}
							},
							error(err) {
								uni.hideLoading();
								that.requestSet.showToast('fail');
								uni.hideLoading();
							},
							complete(res) {

							}
						});

					}
				});

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
