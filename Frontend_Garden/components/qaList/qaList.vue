<template>
	<view>
		<view class="bb1 mt20" v-for="(item,index) in list" @click="toInfo(item,index)">
			<view class="flex itc mb20">
				<view class=" mr20 oh" style="width: 70rpx;height: 70rpx;" v-if="showUserInfo">
					<!-- <image :src="url+item.userpic" mode="" class="avt"></image> -->
					<img-cache :customStyle="customStyle" :src="$r.imgUrl+item.avatar" width="70rpx" height="70rpx"
						mode="aspectFill" bgSrc="../../static/images/loading.png"></img-cache>
				</view>
				<view class="flex_1 oh1 fz30 mr20 c3">
					<view class="oh1" v-if="showUserInfo">
						<view class="oh1 mr20"  style="display: block;max-width: 300rpx;">{{item.nickname}}</view>
					</view>
					<view class="">
						<view class="fz24 c9">{{$r.initTime(item.create_time*1000)}}</view>
					</view>
				</view>
				<!--  -->
				<!-- 未结束状态 -->
				<view class="mr30" v-if="item.resolved_status == 1">
					<view class="flex itc">
						<view class="mr10">
							<image src="../../static/images/qa1.jpg" mode=""
								style="width: 35rpx; height: 35rpx;display: block;"></image>
						</view>
						<view class="fz26" style="color: #ffd03a;">{{item.integer_sum}}</view>
					</view>
				</view>
				<!-- 已结束状态 -->
				<view class="mr30" v-else>
					<view class="flex itc">
						<view class="mr10">
							<image src="../../static/images/qa2.jpg" mode=""
								style="width: 35rpx; height: 35rpx;display: block;"></image>
						</view>
						<view class="fz26 ca">Resolved</view>
					</view>
				</view>
				<view v-if="showUserInfo">
					<view class="follow_btn flex itc juc " :class="{'btn_bg' : item.is_follow}"
						 @click.stop="followFn(item)">
						<view class="iconjia cf fz18 mr5" v-if="!item.is_follow"></view>
						<view class="fz28 cf">{{!item.is_follow ? 'follow' : 'following'}}</view>
					</view>
				</view>
			</view>
			<!--  -->
			<view class="fz28 c3 mb10 oh2">{{item.title}}</view>
			<view class="fz24 c6 mb10 oh2">{{item.content}}</view>
			<view class="" v-if="item.pics">
				<!-- 单徒模式 -->
				<view class="" v-if="item.pics.length < 2">
					<img-cache v-if="item.pics[0].url" :customStyle="customStyle1" :src="url + item.pics[0].url"
						width="690rpx" height="324rpx" mode="aspectFill" bgSrc="../../static/images/loading.png">
					</img-cache>
				</view>
				<!-- 多图模式 -->
				<view class="flex itc" v-else>
					<!--  -->
					<view class="multiple" v-for="(imgs,index) in item.pics">
						<img-cache v-if="imgs && index<3" :src="url + imgs.url" :customStyle="customStyle1" width="218rpx"
							height="218rpx" mode="aspectFill" bgSrc="../../static/images/loading1.png"></img-cache>
					</view>
				</view>
			</view>	
			
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
						<view class="fz24 c9">{{item.answer_sum}}</view>
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
	</view>
</template>

<script>
	/*
		props
			1. list = []   数据列表
			2. componentsIndex = Object {id:0,name:'all'} 组件标志
			3.className 当前小分类名称
		emit事件 operation
			 2.follow=关注事件
			 {
				 componentsIndex: this.componentsIndex, //当前分类数据
				 op: 'follow', // 操作说明
				 index: index, // 列表索引
				 infoType: 'qa' // 列表类型
			 }
	*/
	export default {
		data() {
			return {
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				customStyle: {
					borderRadius: '50%'
				},
				customStyle1: {
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
		created() {

		},
		methods: {
			// 打开详情页面
			toInfo(item, index) {
				uni.navigateTo({
					url: "/pages/qa/qaInfo?fromType=qa&showQaBtn=true&id=" + (item.id || item.question_id)
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
		width: 690rpx;
		height: 324rpx;
		border-radius: 10rpx;
		overflow: hidden;
		background-size: cover;
		background-position: center;
	}

	.multiple_img {
		width: 218rpx;
		height: 218rpx;
		overflow: hidden;
		background-size: cover;
		background-position: center;
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
	image{
		border-radius: 5rpx;
	}
</style>
