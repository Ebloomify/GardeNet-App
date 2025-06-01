<template>
	<view>
		<view class="bb1 mt20" v-for="(item,index) in list" @click="toInfo(item,index)">
			<view class="flex itc mb20">
				<view class="mr20" style="width: 70rpx; height: 70rpx;" v-if="showUserInfo">
					<!-- <image :src="url+item.userpic" mode="" class="avt"></image> -->
					<img-cache :src="imgUrl+ item.avatar" :customStyle="customStyle" width="70rpx" height="70rpx" mode="aspectFill" bgSrc="../../static/images/loading1.png"></img-cache>
				</view>
				<view class="flex_1 fz30 mr20 c3">
					<view class="flex itc" v-if="showUserInfo">
						<view class=" oh1 mr20" style="display: block;max-width: 200rpx;">{{item.nickname}}</view>
						<view class="level flex_1">
							<image :src="`../../static/images/l${item.member_level}.png`" mode="widthFix" :class="'l'+item.member_level"></image>
						</view>
					</view>
					<view class="fz24 c9">{{$r.initTime(item.create_time * 1000)}}</view>
				</view>
				<!-- 关注 item.isfollow   已关注-->
				<view v-if="showUserInfo">
					<view class="follow_btn flex itc juc " :class="{'btn_bg' : item.is_follow}" @click.stop="followFn(item)">
						<view class="iconjia cf fz18 mr5" v-if="!item.is_follow"></view>
						<view class="fz28 cf">{{!item.is_follow ? 'follow' : 'following'}}</view>
					</view>
				</view>

			</view>
			<!--  -->
			<view class="flex itc">
				<view class="flex_1 mr30">
					<view class="fz28 c3 mb10 oh1">{{item.title}}</view>
					<view class="fz24 c3 mb10 oh2">{{item.content}}</view>
					<!-- 标签 -->
					<view class="flex oh itc mt10 " style="max-width: 400rpx;">
						<!--  -->
						<view class="tag fz22 ca" v-for="item in tags(item.tags)" v-if="item">{{item}}</view>
						<!--  -->
					</view>
					<!--  -->
					<!-- <view class="flex itc h90" style="justify-content: space-between;" v-if="item.commentnum !== undefined"> -->
					<view class="flex itc h90" style="justify-content: space-between;">
						<view class="">
							<view class="flex itc">
								<view class="iconnice-line c9 fz30 mr10"></view>
								<view class="fz24 c9">{{item.like_sum}}</view>
							</view>
						</view>
						<view class="">
							<view class="flex itc">
								<view class="iconpinglun c9 fz24 mr10"></view>
								<view class="fz24 c9">{{item.comment_sum}}</view>
							</view>
						</view>
						<view class="">
							<view class="flex itc">
								<view class="iconyanjing c9 fz32 mr10"></view>
								<view class="fz24 c9">{{item.see_sum}}</view>
							</view>
						</view>
					</view>
				</view>
				<!-- 图片 -->
				<view>
					<view class="" v-if="item.pics">
						<img-cache v-if="item.pics[0].url" :src="imgUrl+item.pics[0].url" :customStyle="customStyle1" width="218rpx" height="218rpx" mode="aspectFill" bgSrc="../../static/images/loading1.png"></img-cache>
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
			3.className 当前小分类名称
		
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
				imgUrl: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
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
			},
			className: {
				type: String,
				default: ""
			}
		},
		methods: {
			// 打开详情页面
			// newid
			toInfo(item, index) {

				uni.navigateTo({
					// url: "/pages/info/info?fromType=bbs&id=" + (item.newid ? item.newid : item.id) + '&className='+this.className
					url: "/pages/bbs/bbsInfo?fromType=bbs&id=" + (item.id || item.community_article_id)
				})
			},
			// 关注
			followFn(item) {
				if (!this.token) {
					uni.navigateTo({
						url: "/pages/login/login"
					});
					return;
				};
				var datas = {
					follow_member_id: item.member_id
				};
				this.requestSet.getData(datas, '/V1.MemberFollow/addAndRemove', 'POST').then((res) => {
					if (res.status == 200) {
						if(res.msg == '关注成功') {
							this.$emit('followFn', {"status": true ,"memberId": item.member_id})
						} else if(res.msg == '取消关注成功'){
							this.$emit('followFn', {"status": false ,"memberId": item.member_id})
						};
						this.$r.showToast('Success');
					} else {
						this.requestSet.showToast(res.msg);
					};
				}).catch((err) => {
					console.log(err)
				});
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
