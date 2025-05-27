<template>
	<view>
		<view class="bb1 mt20" v-for="(item,index) in list" @click="toInfo(item,index)">
			<view class="flex itc mb20">
				<view class="mr20" style="width: 70rpx; height: 70rpx;" v-if="showUserInfo">
					<!-- <image :src="url+item.userpic" mode="" class="avt"></image> -->
					<img-cache :src="url+item.userpic" :customStyle="customStyle" width="70rpx" height="70rpx" mode="aspectFill" bgSrc="../../static/images/loading1.png"></img-cache>
				</view>
				<view class="flex_1 fz30 mr20 c3">
					<view class="flex itc" v-if="showUserInfo">
						<view class=" oh1 mr20">{{item.nickname}}</view>
						<view class="level flex_1">
							<image :src="`../../static/images/l${item.vipid}.png`" mode="widthFix" :class="'l'+item.vipid"></image>
						</view>
					</view>
					<view class="fz24 c9">{{item.addtime}}</view>
				</view>
				<!-- 关注 item.isfollow == 1  已关注-->
				<view v-if="showUserInfo">
					<view class="follow_btn flex itc juc " :class="{'btn_bg' : item.isfollow == 0}" @click.stop="followFn('follow',index)">
						<view class="iconjia cf fz18 mr5" v-if="item.isfollow == 0"></view>
						<view class="fz28 cf">{{item.isfollow == 0 ? 'follow' : 'following'}}</view>
					</view>
				</view>

			</view>
			<!--  -->
			<view class="flex itc">
				<view class="flex_1 mr30">
					<view class="fz34 c3 mb10 oh2">{{item.name}}</view>
					<!-- 标签 -->
					<view class="flex oh itc mt10 " style="max-width: 400rpx;">
						<!--  -->
						<view class="tag fz22 ca" v-for="item in tags(item.tags)" v-if="item">{{item}}</view>
						<!--  -->
					</view>
					<!--  -->
					<view class="flex itc h90" style="justify-content: space-between;">
						<view class="">
							<view class="flex itc">
								<view class="iconnice-line c9 fz30 mr10"></view>
								<view class="fz24 c9">{{item.likenum}}</view>
							</view>
						</view>
						<view class="">
							<view class="flex itc">
								<view class="iconpinglun c9 fz24 mr10"></view>
								<view class="fz24 c9">{{item.commentnum}}</view>
							</view>
						</view>
						<view class="">
							<view class="flex itc">
								<view class="iconyanjing c9 fz32 mr10"></view>
								<view class="fz24 c9">{{item.looknum}}</view>
							</view>
						</view>
					</view>
				</view>
				<!-- 图片 -->
				<view>
					<view class="">
						<!-- <image src="../../static/images/i_03.jpg" mode="" class="big_img"></image> -->
						<!-- <view :style="{backgroundImage:`url(${url}${getPic(item.pics)[0]})`}" class="big_img" v-if="getPic(item.pics)[0]"></view> -->
						<img-cache v-if="getPic(item.pics)[0]" :src="url+getPic(item.pics)[0]" :customStyle="customStyle1" width="218rpx" height="218rpx" mode="aspectFill" bgSrc="../../static/images/loading1.png"></img-cache>
						<!--<view :style="{backgroundImage:`url(${url}${getPic(item.pics)[0]})`}" class="big_img" v-if="getPic(item.pics)[0]"></view> -->
					</view>
				</view>
			</view>
			<view class="h20"></view>

		</view>
	</view>
</template>

<script>
	/*
		props
			1. list = []   数据列表
			2. componentsIndex = Object {id:0,name:'all'} 组件标志
		
		emit事件 operation
			1.see=增加观看量事件。
			  {
				  op: 'see',
				  componentsIndex: this.componentsIndex,
				  infoType: 'bbs',
				  id: item.id,
				  index: index
			  }
			 2.follow=关注事件
			 {
				 componentsIndex: this.componentsIndex, //当前分类数据
				 op: 'follow', // 操作说明
				 index: index, // 列表索引
				 infoType: 'bbs' // 列表类型
			 }
	*/
	export default {
		data() {
			return {
				url: this.requestSet.ajaxUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				customStyle:{
					borderRadius: '50%'
				},
				customStyle1:{
					borderRadius: '10rpx'
				}
			}
		},
		/*
			showUserInfo  控制列表中的头像和关注按钮是否显示
		*/
		props: {
			showUserInfo: {
				type: Boolean,
				default: true
			},
			componentsIndex: {
				type: Object
			},
			list: {
				type: Array,
				default: []
			}
		},
		methods: {
			// 打开详情页面
			toInfo(item, index) {
				// 广播增加观看量
				this.$emit('operation', {
					op: 'see',
					componentsIndex: this.componentsIndex,
					infoType: 'bbs',
					id: item.id,
					index: index
				});
				uni.navigateTo({
					url: "/pages/info/info?fromType=bbs&id=" +item.id
				})
			},
			// 关注
			followFn(op, index) {
				if (!this.token) {
					uni.navigateTo({
						url: "/pages/login/login"
					});
					return;
				};
				this.$emit('operation', {
					componentsIndex: this.componentsIndex, //当前分类数据
					op: op, // 操作说明
					index: index, // 列表索引
					infoType: 'bbs' // 列表类型
				});
			},
			// 切割图片路径
			getPic(item) {
				if (item) {
					return item.split('^')
				} else {
					return [];
				};
			},
			//标签切割
			tags(str) {
				if (str) {
					return str.split(',');
				} else {
					return [];
				}
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
		width: 218rpx;
		height: 218rpx;
		overflow: hidden;
		border-radius: 10rpx;
		background-position: center center;
		background-repeat: no-repeat;
		background-size: cover;
	}

	.ml40 {
		margin-left: 40rpx;
	}

	.level image {
		display: block;
	}

	.tag {
		margin-right: 26rpx;
		line-height: 34rpx;
		border-radius: 18rpx;
		border: 1rpx #48ceb5 solid;
		padding: 0 20rpx;
		overflow: hidden;
	}
</style>
