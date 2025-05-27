<template>
	<view>
		<markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer>
		<u-navbar>
			<view class="search_box mr20 tac w100">{{param.from == 'bbs' ? 'Community Post': ' Q&A Post'}}</view>
			<view slot="right">
				<view class="cf fz28 submit tac mr20" @click="submit">Submit</view>
			</view>
		</u-navbar>
		<!--  -->
		<view class="p0_30">
			<!-- 标题 -->
			<view class="bb1 flex itc h100">
				<input maxlength="-1"  type="text" value="" placeholder="Title (5-30 words)" class="fz30 c3 w100" v-model="title" />
			</view>
			<!-- 标签 -->
			<view class="bb1 flex itc h100" v-if="param.from == 'bbs'">
				<input maxlength="-1"  type="text" value="" placeholder="tags,tags" class="fz30 c3 w100" v-model="tags" />
			</view>
			<!-- 详情 -->
			<view class="bb1">
				<view class="h20"></view>
				<textarea maxlength="-1" placeholder="Enter text~" class="fz30 c3 w100" v-model="desc"></textarea>
				<view class="h20"></view>
			</view>
			<!-- 提示 -->
			<view>
				<view class="h20"></view>
				<view v-if="param.from == 'bbs'">
					<u-popup v-model="help" mode="center" width="90%">
						<view class="p30">
							<view class="flex itc juc mb20">
								<view class="fz30 c3 flex_1">Proposal</view>
								<view class="iconguanbi" @click="help = false"></view>
							</view>
							<view class="fz28 c9 lh50">
								1. Publish the original <br>
								2. The contents are correct and there are pictures<br>
								3. No advertising will be banned
							</view>
						</view>
					</u-popup>
				</view>
				<!--  -->
				<view v-else>
					<view v-show="help" class="bor10 bgf4 p20">
						<u-popup v-model="help" mode="center" width="90%">
							<view class="p30">
								<view class="flex itc juc mb20">
									<view class="fz30 c3 flex_1">Give an example</view>
									<view class="iconguanbi" @click="help = false"></view>
								</view>
								<view class="fz28 c9 lh50">
									Question: what about yellow leaves?<br>
									Description: what if the leaves turn yellow?what
									if the leaves turn yellow?what if the leaves turn
									yellow?
								</view>
							</view>
						</u-popup>

					</view>

				</view>
			</view>

			<view class="h20"></view>
			<!-- 图片上传 -->
			<view class="">
				<u-upload :action="action" :file-list="fileList" max-count="6" upload-text="" @on-remove="remImg"
					@on-success="upSuccess" name="file" :header="headerData"></u-upload>
			</view>
			<view class="h20"></view>
			<!-- 类型选择 -->
			<view class="flex " v-if="list">
				<view>
					<view class="flex itc p0_30 h60 typeBox" @click="show = true">
						<image src="../../static/images/type.jpg" mode="" class="typeImg"></image>
						<view class="fz26 mr20" style="color: #6c9bf5;"> {{checkClassName || 'Type'}}
						</view>
						<view class="iconxiala fz26 ca"></view>
					</view>
				</view>
			</view>
			<!-- :default-value="[listIdex]" -->
			<u-select label-name="cate_name" :value-name="valueName" v-model="show" :list="list" title="Select section"
				confirm-text="confirm" cancel-text="cancel" @confirm="confirm">
			</u-select>
			<!-- qa选择价格 -->
			<view v-if="param.from == 'qa'">
				<view class="h40"></view>
				<view class="fz32 c3 fw9 mb20">Choose reward points</view>
				<view class="fz24 c9">Remaining available points:
					<text class="c3 fz30 pl20 fw9 pr20" style="color: #ffd03a;">{{userInfo.data.integral}}</text>
					points
				</view>
				<view class="flex juc itc p20_0 price_box">
					<!--  -->
					<view class="price_list tac flex_1" v-for="(item,index) in priceList"
						:class="{'active' :priceIndex == index}" @click="priceIndex = index">
						<image src="../../static/images/q_06.png" mode="widthFix" style="width: 73rpx;"></image>
						<view class="fz28" style="color: #ffd03a;">{{item}}</view>
					</view>
					<!--  -->
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				headerData: {
					"Authorization": "",
				},
				timestamp: Date.parse(new Date()), //时间戳等于页面名称
				isMark: true, //是否显示页面遮罩 
				markType: 1,
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				tabList: [], //分类数据
				isSubmit: false,
				show: false,
				list: [], //分类数据
				valueName: "", // 下拉选择器的名称key值
				checkClassName: "", // 选中的分类名称
				checkClassId: "", //选中的分类Id
				listIdex: 0, //分类索引
				priceList: [50, 100, 150, 200, 250, 300], //价格列表
				priceIndex: -1, //价格索引
				action: `${this.$r.ajaxUrl}/Base/upload`,
				fileList: [], //默认图片{url:""}
				param: {},
				help: true, //显示帮助标志
				title: "", //标题
				desc: "", //详情
				tags: "", //标签
				imgArr: [], //上传图片数组
				isLoading: false,
				editInfo: {}
			}
		},
		onLoad(option) {
			this.param = option;
			if (option.item) {

				if (this.param.from == 'bbs') {

				} else {
					var _editInfo = JSON.parse(option.item);
					this.editInfo = _editInfo
					this.title = _editInfo.title;
					this.desc = _editInfo.content;
					// 设置已选积分
					this.priceIndex = this.priceList.indexOf(Number(_editInfo.integer_sum));
					// 设置分类名称
					this.checkClassName = _editInfo.cate_name;
					// 设置分类ID
					this.checkClassId = _editInfo.question_cate_id;
					this.initEditImg(_editInfo.pics);
				};

			};
			this.getList();
			this.headerData.Authorization = this.token;
			if (this.param.from == 'bbs') {
				this.valueName = "community_cate_id";
			} else {
				this.valueName = "question_cate_id";
			}
		},
		methods: {
			// 处理修改图片
			initEditImg(list) {
				var _fileList = [],
					_imgArr = [];
				for (var i = 0; i < list.length; i++) {
					_fileList.push({
						url: this.$r.imgUrl + list[i].url
					});
					_imgArr.push(list[i].url);
				}
				this.fileList = _fileList;
				this.imgArr = _imgArr;
			},
			//删除图片
			remImg(e) {
				this.imgArr.splice(e, 1);
				// console.log(this.imgArr)
			},
			//图片上传成功
			upSuccess(e) {
				this.imgArr.push(e.data);
			},
			confirm(e) {
				this.checkClassId = e[0].value;
				this.checkClassName = e[0].label;

			},
			submit() {
				if (this.isSubmit) return;
				if (!this.title) {
					this.requestSet.showToast('Please enter a title');
					return;
				};
				if (!this.desc) {
					this.requestSet.showToast('Please enter details');
					return;
				};
				if (this.checkClassId === '') {
					this.requestSet.showToast('Please select type');
					return;
				};
				if (this.param.from == 'qa') {
					if (this.priceIndex === -1) {
						this.requestSet.showToast('Please select points');
						return;
					}
					// 积分不足
					if (this.priceList[this.priceIndex] > this.userInfo.data.integral && !this.param.id) {
						this.requestSet.showToast('Insufficient points');
						return;
					}
				};

				var datas, _url, _imgObj = [],
					_imgList = this.imgArr;
				for (var i = 0; i < _imgList.length; i++) {
					_imgObj.push({
						url: _imgList[i],
						title: ""
					})
				};
				if (this.param.from == 'bbs') {
					_url = "/V1.CommunityArticle/add";
					datas = {
						community_cate_id: this.checkClassId,
						title: this.title,
						content: this.desc,
						tags: this.tags,
						pics: JSON.stringify(_imgObj),
					};
				} else if (this.param.from == 'qa') {
					_url = "/V1.Question/add";
					datas = {
						question_cate_id: this.checkClassId,
						title: this.title,
						content: this.desc,
						pics: JSON.stringify(_imgObj),
						integer_sum: this.priceList[this.priceIndex]
					};
				};
				if (this.param.id) {
					if (this.param.from == 'bbs') {
						datas.community_article_id = this.param.id;
						_url = "/V1.CommunityArticle/update";
					} else {
						datas.question_id = this.param.id;
						_url = "/V1.Question/update";
					}
				}
				// console.log(datas);
				// return;
				uni.showLoading({
					mask: true,
					title: "Loading"
				})
				this.isSubmit = true;
				this.requestSet.getData(datas, _url, 'POST').then((res) => {
					if (res.status == 200) {
						this.requestSet.showToast('success');
						setTimeout(() => {
							var _id = res.data.id;
							if (this.param.from == 'qa') {
								var _url = `/pages/qa/qaInfo?fromType=qa&showQaBtn=true&id=${_id}`
							} else {
								var _url = `/pages/bbs/bbsInfo?fromType=bbs&id=${_id}`
							};
							uni.redirectTo({
								url: _url
							})
						}, 1000);
					} else {
						this.isSubmit = false;
						this.requestSet.showToast(res.msg);
					};
				}).catch((err) => {
					this.isSubmit = false;
				});
			},
			//获取分类列表
			getList() {
				var datas, _url;
				if (this.param.from == 'bbs') {
					_url = "/V1.CommunityCate/index";
					datas = {
						page: 1,
						limit: 10000,
						is_under: 0
					}
				} else if (this.param.from == 'qa') {
					_url = "/V1.QuestionCate/index";
					datas = {
						page: 1,
						limit: 10000,
						is_under: 0
					}
				};
				this.requestSet.getData(datas, _url, 'GET').then((res) => {
					if (res.status == 200) {
						this.list = res.data.list;

						if (this.param.from == 'bbs' && this.param.id) {
							this.getInfo();
						} else {
							this.isMark = false;
						}
					} else {
						this.requestSet.showToast(res.msg);
					};
				}).catch((err) => {
					this.markType = 2;
				});
			},
			getInfo() {
				var datas, _url;
				// console.log(this.param)
				datas = {
					community_article_id: this.param.id,
				};
				_url = '/V1.CommunityArticle/view';
				this.requestSet.getData(datas, _url, 'GET').then((res) => {
					if (res.status == 200) {
						var _editInfo = res.data;
						this.title = _editInfo.title;
						this.desc = _editInfo.content;
						this.tags = _editInfo.tags;
						// 设置分类名称
						this.checkClassName = _editInfo.cate_name;
						// 设置分类ID
						this.checkClassId = _editInfo.cate_id;
						this.initEditImg(_editInfo.pics);
					} else {
						this.requestSet.showToast(res.msg);
					}
					setTimeout(() => {
						this.isMark = false;
					}, 500)
				}).catch((err) => {
					console.log(err)
					this.isMark = true;
					this.markType = 2;
				});
			},
			refresh(data) { //刷新当前页数据
				if (data == this.timestamp) {
					this.getList();
				}
			},
		}
	}
</script>

<style>
	.submit {
		background-image: linear-gradient(to right, #52d0bb, #48d39a);
		width: 150rpx;
		line-height: 60rpx;
		border-radius: 30rpx;
	}

	.typeImg {
		width: 30rpx;
		height: 30rpx;
		margin-right: 20rpx;

	}

	.typeBox {
		background: #f6f7f9;
		border-radius: 30rpx;
	}

	.p20_0 {
		padding: 30rpx 0;
	}

	.price_list {
		opacity: .5;
	}

	.price_box .active {
		opacity: 1;
	}
</style>
