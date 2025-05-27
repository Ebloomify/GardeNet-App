<template>
	<view>
		<view class="bb1 mt20" @click="toInfo(item,index)" v-for="(item,index) in list">
			<!-- <view class="flex itc mb10">
				<view class=" mr20">
					<image src="../../static/images/i_06.jpg" mode="widthFix" class="avt"></image>
				</view>
				<view class="flex_1 oh1 fz30 mr20 c3">
					<text>Beenda Hernandez</text>
				</view>
				<view class="follow_btn flex itc juc btn_bg">
					<view class="iconjia cf fz18 mr5"></view>
					<view class="fz28 cf">follow</view>
				</view>
			</view> -->
			<!--  -->
			<view class="fz34 c3 mb10 oh2">{{item.title}}</view>
			<!-- 单徒模式 -->
			<view class="" v-if="item.pic.length < 3">
				<!-- <view :style="{backgroundImage:`url(${url}${getPic(item.pic)[0]})`}" class="big_img"></view> -->
				<img-cache v-if="item.pic[0].url" :customStyle="customStyle" :src="imgUrl + item.pic[0].url"
					width="690rpx" height="324rpx" mode="aspectFill" bgSrc="../../static/images/loading.png">
				</img-cache>
			</view>
			<!-- 多图模式 -->
			<view class="flex itc" v-else>
				<!--  -->
				<view class="multiple" v-for="(imgs,index) in item.pic">
					<!-- <view :style="{backgroundImage:`url(${url}${imgs})`}" class="bor10 multiple_img" v-if="imgs"></view> -->
					<img-cache v-if="imgs.url" :src="imgUrl + imgs.url" :customStyle="customStyle" width="218rpx" height="218rpx"
						mode="aspectFill" bgSrc="../../static/images/loading1.png"></img-cache>
				</view>

			</view>
			<view class="flex itc h90">
				<view class="fz24 c9 flex_1">{{$r.initTime(item.create_time * 1000)}}</view>
				<!-- <view class="ml40" v-show="showlookNum">
					<view class="flex itc">
						<view class="iconpinglun c9 fz24 mr10"></view>
						<view class="fz24 c9">{{item.commentnum}}</view>
					</view>
				</view> -->
				<view class="ml40" v-show="showlookNum">
					<view class="flex itc">
						<view class="iconyanjing c9 fz32 mr10"></view>
						<view class="fz24 c9">{{item.see_sum}}</view>
					</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	/*
		props
			1. list = []   数据列表
			2. componentsIndex = Object {id:0,name:'all'} 组件标志
			3.showlookNum 是否显示 新闻观看量和评论数量
			4.className 当前小分类名称
		
		emit事件
			1.see=增加观看量事件。
			  {
				  componentsIndex: this.componentsIndex, 组件标志
				  infoType: 'Discover',
				  id: '文章ID',
				  index: '文章索引'
			  }
	*/
	export default {
		data() {
			return {
				url: this.requestSet.ajaxUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				imgUrl: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				customStyle: {
					borderRadius: '10rpx'
				}
			}
		},
		created() {

		},
		// props: ['componentsIndex', 'list'],
		props: {
			componentsIndex: {
				type: Object
			},
			list: {
				type: Array,
				default: []
			},
			showlookNum: {
				type: Boolean,
				default: true
			},
			className: {
				type: String,
				default: ""
			}
		},
		methods: {
			// 切割图片路径
			getPic(item) {
				if (item) {
					return item.split('^')
				} else {
					return [];
				};
			},
			toInfo(item, index) {
				uni.navigateTo({
					// url: "/pages/info/info?fromType=discover&id=" + item.id + '&className='+this.className
					url: "/pages/index/disInfo?fromType=discover&id=" + item.id
				})
			}
		}
	}
</script>

<style>
	.avt {
		width: 70rpx;
		height: 70rpx;
		border-radius: 50%;
		overflow: hidden;
	}

	.follow_btn {
		width: 135rpx;
		height: 50rpx;
		border-radius: 25rpx;
		background-color: #dfdfdf;
	}

	.btn_bg {
		background: linear-gradient(to right, #48cfb0, #48d39d);
		/* background: -webkit-linear-gradient(top, #48cfb0 ,#48d39d ); */
	}

	.big_img {
		width: 690rpx;
		height: 324rpx;
		border-radius: 10rpx;
		overflow: hidden;
		background-position: center center;
		background-repeat: no-repeat;
		background-size: cover;
	}

	.multiple_img {
		width: 218rpx;
		height: 218rpx;
		overflow: hidden;
		background-position: center center;
		background-repeat: no-repeat;
		background-size: cover;
	}

	.multiple {
		margin-right: 18rpx;
	}

	.mr0 {
		margin-right: 0;
	}

	.ml40 {
		margin-left: 40rpx;
	}
</style>
