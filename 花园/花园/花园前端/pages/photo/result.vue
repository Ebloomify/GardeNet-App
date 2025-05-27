<template>
	<view>
		<view>
			<!-- <swiper :autoplay="false" :interval="3000" :duration="500">
				<swiper-item v-for="(item,index) in 2">
					<view class="swiper-item">
						<image src="../../static/images/i_06.jpg" mode="aspectFill" class="w100"></image>
					</view>
				</swiper-item>
			</swiper> -->
			<image :src="url + img" mode="widthFix" class="w100"></image>
		</view>
		<!--  -->
		<view class="info_box">
			<view v-if="!param.results || !param.results.length">
				<view class="h100"></view>
				<u-empty text="No List" mode="list"></u-empty>
			</view>
			<view v-else>
				<view class="title" v-for="item in param.results">
					<view class="fz34 c3 mb10">{{item.species.scientificNameWithoutAuthor}}</view>
					<view class="flex itc">
						<view class="fz26 c9 ca mr40">{{item.species.commonNames.join(',')}}</view>
						<view class="fz26 c9">{{item.species.family.scientificNameWithoutAuthor}}</view>
					</view>
					<!--  -->
					<view class="h30"></view>
					<view class="flex itc">
						<view class="confirm mr40 tac ca fw9" @click="nav(item)">confirm</view>
						<view class="fz26 c6">Score：{{subStr(item.score)}}</view>
					</view>
				</view>
				<view class="oh">
					<view class=" tac ca no_btn" @click="back">Nothing matches the plant</view>
				</view>
			</view>

		</view>
	</view>
</template>

<script>
	var _list = {
		"list": "{\"query\":{\"project\":\"best\",\"images\":[\"18ff65c01d2837ee06621f31f14cbb0e\"],\"organs\":[\"flower\"]},\"language\":\"en\",\"preferedReferential\":\"the-plant-list\",\"results\":[{\"score\":0.22994720935821533,\"species\":{\"scientificNameWithoutAuthor\":\"Gentiana brachyphylla\",\"scientificNameAuthorship\":\"Vill.\",\"genus\":{\"scientificNameWithoutAuthor\":\"Gentiana\",\"scientificNameAuthorship\":\"\"},\"family\":{\"scientificNameWithoutAuthor\":\"Gentianaceae\",\"scientificNameAuthorship\":\"\"},\"commonNames\":[\"Kurzblttriger Enzian\",\"Short-leaved Gentian\"]},\"gbif\":{\"id\":\"7270252\"}},{\"score\":0.05495733767747879,\"species\":{\"scientificNameWithoutAuthor\":\"Eustoma grandiflorum\",\"scientificNameAuthorship\":\"(Raf.) Shinners\",\"genus\":{\"scientificNameWithoutAuthor\":\"Eustoma\",\"scientificNameAuthorship\":\"\"},\"family\":{\"scientificNameWithoutAuthor\":\"Gentianaceae\",\"scientificNameAuthorship\":\"\"},\"commonNames\":[\"Showy prairie gentian\"]},\"gbif\":{\"id\":\"6366868\"}},{\"score\":0.02697470784187317,\"species\":{\"scientificNameWithoutAuthor\":\"Clitoria ternatea\",\"scientificNameAuthorship\":\"L.\",\"genus\":{\"scientificNameWithoutAuthor\":\"Clitoria\",\"scientificNameAuthorship\":\"\"},\"family\":{\"scientificNameWithoutAuthor\":\"Leguminosae\",\"scientificNameAuthorship\":\"\"},\"commonNames\":[\"Cordofan-pea\",\"Butterfly-pea\",\"Darwin-pea\"]},\"gbif\":{\"id\":\"2946519\"}},{\"score\":0.02154133841395378,\"species\":{\"scientificNameWithoutAuthor\":\"Gentiana bavarica\",\"scientificNameAuthorship\":\"L.\",\"genus\":{\"scientificNameWithoutAuthor\":\"Gentiana\",\"scientificNameAuthorship\":\"\"},\"family\":{\"scientificNameWithoutAuthor\":\"Gentianaceae\",\"scientificNameAuthorship\":\"\"},\"commonNames\":[\"Bavarian Gentian\"]},\"gbif\":{\"id\":\"7270316\"}},{\"score\":0.012184237129986286,\"species\":{\"scientificNameWithoutAuthor\":\"Jasminum sambac\",\"scientificNameAuthorship\":\"(L.) Aiton\",\"genus\":{\"scientificNameWithoutAuthor\":\"Jasminum\",\"scientificNameAuthorship\":\"\"},\"family\":{\"scientificNameWithoutAuthor\":\"Oleaceae\",\"scientificNameAuthorship\":\"\"},\"commonNames\":[\"Arabian jasmine\",\"Sambac jasmine\",\"Pikake\"]},\"gbif\":{\"id\":\"7587215\"}},{\"score\":0.00755068426951766,\"species\":{\"scientificNameWithoutAuthor\":\"Ipomoea nil\",\"scientificNameAuthorship\":\"(L.) Roth\",\"genus\":{\"scientificNameWithoutAuthor\":\"Ipomoea\",\"scientificNameAuthorship\":\"\"},\"family\":{\"scientificNameWithoutAuthor\":\"Convolvulaceae\",\"scientificNameAuthorship\":\"\"},\"commonNames\":[\"Japanese morning-glory\",\"Blue morning-glory\",\"White-edge morning-glory\"]},\"gbif\":{\"id\":\"2928534\"}},{\"score\":0.005432343576103449,\"species\":{\"scientificNameWithoutAuthor\":\"Aquilegia alpina\",\"scientificNameAuthorship\":\"L.\",\"genus\":{\"scientificNameWithoutAuthor\":\"Aquilegia\",\"scientificNameAuthorship\":\"\"},\"family\":{\"scientificNameWithoutAuthor\":\"Ranunculaceae\",\"scientificNameAuthorship\":\"\"},\"commonNames\":[\"Alpine Columbine\"]},\"gbif\":{\"id\":\"3921499\"}},{\"score\":0.0054194130934774876,\"species\":{\"scientificNameWithoutAuthor\":\"Gentiana alpina\",\"scientificNameAuthorship\":\"Vill.\",\"genus\":{\"scientificNameWithoutAuthor\":\"Gentiana\",\"scientificNameAuthorship\":\"\"},\"family\":{\"scientificNameWithoutAuthor\":\"Gentianaceae\",\"scientificNameAuthorship\":\"\"},\"commonNames\":[\"Southern gentian\",\"Alpine Gentian\"]},\"gbif\":{\"id\":\"7270543\"}},{\"score\":0.0053301118314266205,\"species\":{\"scientificNameWithoutAuthor\":\"Gentiana utriculosa\",\"scientificNameAuthorship\":\"L.\",\"genus\":{\"scientificNameWithoutAuthor\":\"Gentiana\",\"scientificNameAuthorship\":\"\"},\"family\":{\"scientificNameWithoutAuthor\":\"Gentianaceae\",\"scientificNameAuthorship\":\"\"},\"commonNames\":[\"Bladder Gentian\"]},\"gbif\":{\"id\":\"8352976\"}}],\"remainingIdentificationRequests\":47}",
		"img": "/shopimages/1717386235.jpeg"
	}

	export default {
		data() {
			return {
				param: {},
				img: "",
				list: _list,
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
			}
		},
		onLoad(option) {
			console.log(option.list)
			this.param = this.searchInfo;
			// this.param = option.list;
			this.img = option.img;
			// this.param = JSON.parse(_list.list);
			// this.img = _list.img;
			// console.log(this.param.results);
		},
		methods: {
			back() {
				uni.navigateBack({
					delta: 1
				})
			},
			subStr(str) {
				if (str) {
					return String(str).substring(0, 5);
				}
			},

			nav(item) {
				if (!this.userInfo || !this.token) {
					uni.navigateTo({
						url: "/pages/login/login"
					});
					return;
				};
				uni.showModal({
					title: 'Tips',
					content: 'Add the plant to my garden',
					confirmText: "OK",
					cancelText: "Cancel",
					success: (res) => {
						if (res.confirm) {
							var str =
								`?pageFrom=search&img=${this.img}&fName=${item.species.scientificNameWithoutAuthor}&fDesc=${item.species.commonNames.join(',')}`;
							uni.navigateTo({
								url: `/pages/center/garden/add${str}`
							})
						}
					}
				});

			}
		}
	}
</script>

<style>
	.img {
		width: 100%;
		height: 450rpx;
		background-size: cover;
		background-position: center center;
	}

	.info_box {
		background: #fff;

	}

	.title {
		border-bottom: 6rpx solid #f7f7f7;
		padding: 20rpx 30rpx;
	}

	.line_title {
		line-height: 34rpx;
		height: 34rpx;
		border-left: 6rpx solid #5fcfa0;
		text-indent: 30rpx;
	}

	.pl50 {
		padding-left: 50rpx;
	}

	.confirm {
		width: 350rpx;
		line-height: 80rpx;
		border: 2rpx solid #ddd;
		border-radius: 40rpx;
	}

	.no_btn {
		line-height: 80rpx;
		border: 2rpx solid #ddd;
		border-radius: 40rpx;
		width: 80%;
		margin: 40rpx auto;
	}

	.mr40 {
		margin-right: 40rpx;
	}
</style>
