<template>
	<view>
		<view class="list boxSha boxSha bor20 mb30 p20 flex itc" v-for="item in list" @click="nav('/pages/center/garden/info?from=look&id='+item.id)">
			<view class="avts mr30">
				<image :src="url + getPic(item.img)[0]" mode="" class="bor10 oh" v-if="getPic(item.img)[0]"></image>
			</view>
			<view class="flex_1">
				<view class="fz34 c3 oh1">{{item.plant_name}}</view>
				<view class="fz28 c6 oh1 mb10">{{item.plant_introduction}}</view>
			</view>

		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				timestamp: Date.parse(new Date()), //时间戳等于页面名称
				isMark: true, //是否显示页面遮罩 
				markType: 1,
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
			}
		},
		props: {
			isLink: {
				type: Boolean,
				default: true
			},
			list: {
				type: Array,
				default: []
			}
		},
		methods: {
			nav(url) {
				if(this.isLink) {
					uni.navigateTo({
						url: url
					})
				}
			},
			// 切割图片路径
			getPic(item) {
				if (item) {
					return item.split('^')
				} else {
					return [];
				};
			},
		}
	}
</script>

<style>
	.avts {
		width: 160rpx;
		height: 160rpx;
	}

	.avts image {
		width: 100%;
		height: 100%;
		display: block;
	}

	.yuan {
		width: 50rpx;
		height: 50rpx;
		border-radius: 50%;
		font-size: 30rpx;
		color: #fff;
	}
</style>
