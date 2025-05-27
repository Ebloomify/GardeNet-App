<template>
	<view>
		<view class="">
			<view class="list flex bb1 p20_0" v-for="(item,index) in list" @click="nav(item)">
				<view class="read" v-show="item.is_read == 0"></view>
				<view class="avt mr20">
					<view class="fz40 icondanseyuandian red read" v-if="item.isread == 0"></view>
					<!-- <image src="../../../static/images/i_06.jpg" mode=""></image> -->
					<img-cache :customStyle="customStyleAvt" :src="url+item.avatar" width="70rpx" height="70rpx"
						mode="aspectFill" bgSrc="../../static/images/loading1.png"></img-cache>
				</view>
				<view class="flex_1 mr40">
					<view class="fz30 c3 oh1 mb5">{{item.nickname}}</view>
					<view class="fz28 c3 oh1 mb10">{{item.content}}</view>
					<!-- <view class="fz24 c9 oh1">Commented on me</view> -->
					<view class="fz24 c9 oh1"><text class="">{{$r.initTime(item.create_time * 1000)}}</text></view>
					<view></view>
				</view>
				<view class="kuai bor20">
					<view class="flex juc itc" style="width: 100%;height: 100%;">
						<view class="oh2 fz22 c9 p0_20">{{item.title}}</view>
					</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	/*
		article_id = 文章ID
		type = 1  community 
		type = 2  qa
	*/

	export default {
		data() {
			return {
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				customStyleAvt: {
					borderRadius: '50%'
				},
			}
		},
		props: {
			list: {
				type: Array,
				default: []
			}
		},
		methods: {
			setRead(item) {
				var datas, _url;
				// console.log(this.param)
				datas = {
					id: item.id,
					type: item.type
				};
				_url = '/V1.Notification/read';
				this.requestSet.getData(datas, _url, 'GET').then((res) => {
					if (res.status == 200) {
						item.is_read = 1;
					} else {
						this.requestSet.showToast(res.msg);
					}
					
				}).catch((err) => {
					
				});
			},
			nav(item) {
				if (item.type == 1) {
					uni.navigateTo({
						url: "/pages/bbs/bbsInfo?fromType=bbs&id=" + item.article_id
					})
				} else if (item.type == 2) {
					uni.navigateTo({
						url: "/pages/qa/qaInfo?fromType=qa&showQaBtn=true&id=" + item.article_id
					})
				}
				this.setRead(item);
			}
		}
	}
</script>

<style>
	.p20_0 {
		padding: 20rpx 0;
	}

	.avt {
		width: 70rpx;
		height: 70rpx;
		overflow: hidden;
		position: relative;
	}

	.read {
		position: absolute;
		left: -8rpx;
		top: -8rpx;
		z-index: 999;
	}

	.avt image {
		width: 100%;
		height: 100%;
		border-radius: 50%;
		display: block;
	}

	.kuai {
		width: 140rpx;
		height: 140rpx;
		background-color: #efefef;
	}

	.list {
		position: relative;
	}

	.read {
		position: absolute;
		width: 20rpx;
		height: 20rpx;
		border-radius: 50%;
		background: red;
		top: 10rpx;
		left: 0rpx;
	}
</style>
