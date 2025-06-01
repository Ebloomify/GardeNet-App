<template>
	<view>
		<markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer>
		<view class="p0_30">
			<view class="fz30 c3 lh80">Photo</view>
			<view class="">
				<u-upload :action="action" :file-list="fileList" max-count="6" upload-text="" name="file"
					@on-remove="remImg" @on-success="upSuccess" :header="headerData"></u-upload>
			</view>
			<!--  -->
			<view class="fz30 c3 lh80">The common name</view>
			<view class="list_box bor10">
				<view class="flex itc h70 p0_20">
					<view class="flex_1 mr20">
						<input maxlength="-1"  type="text" placeholder="what is this question about..." class="fz28 c3"
							v-model="searchName">
					</view>
					<view class="iconsousuo search_btn tac cf"
						@click="nav('/pages/center/garden/search?keyword=' + searchName)"></view>
				</view>
			</view>
			<!--  -->
			<view class="fz30 c3 lh80">Give your plant a name</view>
			<view class="list_box bor10">
				<view class="flex itc h70 p0_20">
					<view class="flex_1 ">
						<input maxlength="-1"  type="text" class="fz28 c3" v-model="name">
					</view>
				</view>
			</view>
			<!--  -->
			<view class="fz30 c3 lh80">Plant introduction</view>
			<view class="list_box bor10">
				<view class="flex itc h70 p0_20">
					<view class="flex_1 ">
						<input maxlength="-1"  type="text" class="fz28 c3" v-model="descripion">
					</view>
				</view>
			</view>
			<!--  -->
			<view class="fz30 c3 lh80">Duration</view>
			<view class="list_box bor10">
				<view class="flex itc h70 p0_20">
					<view class="flex_1 ">
						<input maxlength="-1"  type="text" class="fz28 c3" v-model="duration">
					</view>
				</view>
			</view>
			<!--  -->
			<view class="fz30 c3 lh80">Flower Color</view>
			<view class="list_box bor10">
				<view class="flex itc h70 p0_20">
					<view class="flex_1 ">
						<input maxlength="-1"  type="text" class="fz28 c3" v-model="color">
					</view>
				</view>
			</view>
			<!--  -->
			<view class="fz30 c3 lh80">Fertilization</view>
			<view class="list_box bor10">
				<view class="flex itc h70 p0_20">
					<view class="flex_1 ">
						<input maxlength="-1"  type="text" class="fz28 c3" v-model="fertilization">
					</view>
				</view>
			</view>
			<!--  -->
			<view class="fz30 c3 lh80">Water</view>
			<view class="list_box bor10">
				<view class="flex itc h70 p0_20">
					<view class="flex_1 ">
						<input maxlength="-1"  type="text" class="fz28 c3" v-model="water">
					</view>
				</view>
			</view>
			<!--  -->
			<view class="fz30 c3 lh80">Exposure</view>
			<view class="list_box bor10">
				<view class="flex itc h70 p0_20">
					<view class="flex_1 ">
						<input maxlength="-1"  type="text" class="fz28 c3" v-model="exposure">
					</view>
				</view>
			</view>
			<!--  -->
			<view class="fz30 c3 lh80">Soil</view>
			<view class="list_box bor10">
				<view class="flex itc h70 p0_20">
					<view class="flex_1 ">
						<input maxlength="-1"  type="text" class="fz28 c3" v-model="soil">
					</view>
				</view>
			</view>
			<!--  -->
			<view class="fz30 c3 lh80">Minimum Tempature</view>
			<view class="list_box bor10">
				<view class="flex itc h70 p0_20">
					<view class="flex_1 ">
						<input maxlength="-1"  type="text" class="fz28 c3" v-model="minimum">
					</view>
				</view>
			</view>
			<!--  -->
			<view class="fz30 c3 lh80">Blooming</view>
			<view class="list_box bor10">
				<view class="flex itc h70 p0_20">
					<view class="flex_1 ">
						<input maxlength="-1"  type="text" class="fz28 c3" v-model="blooming">
					</view>
				</view>
			</view>
			<!--  -->
		</view>
		<view class="h50"></view>
		<view class="p0_30">
			<u-button type="primary" clas="btn h100 " :custom-style="customStyle" :ripple="true" :disabled="disabled"
				@click="submit">submit</u-button>
		</view>
		<view class="h50"></view>
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
				action: `${this.$r.ajaxUrl}/Base/upload`, //图片上传路径
				headerData: {
					"Authorization": "",
				},
				// fileList: [{
				// 	url: 'http://pics.sc.chinaz.com/files/pic/pic9/201912/hpic1886.jpg',
				// }], //默认图片列表
				fileList: [], //默认图片列表
				disabled: false,
				customStyle: {
					height: "80rpx",
					borderRadius: "40rpx",
					backgroundImage: "linear-gradient(to right, #52d0bb, #48d39a)"
				},
				param: {},
				imgArr: [], // 图片列表
				searchName: "", //搜索名称
				name: "", //植物名称
				descripion: '',
				water: '',
				blooming: '',
				soil: '',
				minimum: '',
				fertilization: '',
				exposure: '',
				duration: '',
				color: '',
			}
		},
		onLoad(option) {
			this.headerData.Authorization = this.token;
			this.param = option;
			if (option.id) {
				this.getList();
			} else {
				setTimeout(() => {
					this.isMark = false;
				}, 20)
			}
			if (option.pageFrom == 'search') {
				this.name = option.fName;
				this.descripion = option.fDesc;
				this.fileList = [{
					url: this.url + option.img,
				}];
				this.imgArr.push(option.img);
			}
			uni.$on('searchClickBack', (item) => {
				console.log(item)
				//
				if(item.commonname) {
					this.searchName = item.commonname
				}
				//  植物名称
				if (item.scientificname) {
					this.name = item.scientificname;
				};
				// 
				if (item.droughttolerance) {
					this.water = item.droughttolerance;
				};
				// 
				if (item.fertilityrequirement) {
					this.fertilization = item.fertilityrequirement;
				};
				// 
				if (item.shadetolerance) {
					this.exposure = item.shadetolerance;
				};
				// 
				if (item.bloomperiod) {
					this.blooming = item.bloomperiod;
				};
				// 
				if (item.temperatureminimum) {
					this.minimum = item.temperatureminimum;
				};

			})
		},
		onUnload() {
			uni.$off('searchClickBack');
		},
		methods: {
			//删除图片
			remImg(e) {
				this.imgArr.splice(e, 1);
				// console.log(this.imgArr)
			},
			// 处理修改图片
			initEditImg(list) {
				
				if(list) {
					list = JSON.parse(list)
				} else {
					list = [];
				}
				console.log(list)
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
				console.log(_fileList)
			},
			// 获取花园详情数据
			getList() {
				var datas = {
					id: this.param.id,
				};
				this.requestSet.getData(datas, '/V1.Garden/edit', 'GET').then((res) => {
					if (res.status == 200) {
						// console.log(res)
						var _backData = res.data;
						this.initEditImg(_backData.img)
						this.searchName = _backData.common_name; //搜索名称
						this.name = _backData.plant_name; //植物名称
						this.descripion = _backData.plant_introduction;
						this.water = _backData.water;
						this.blooming = _backData.blooming;
						this.soil = _backData.soil;
						this.minimum = _backData.minimum_tempature;
						this.fertilization = _backData.fertilization;
						this.exposure = _backData.exposure;
						this.duration = _backData.duration;
						this.color = _backData.flower_color;
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
			submit() {
				if (!this.imgArr.length) {
					this.requestSet.showToast('Please upload the picture');
					return;
				};
				if (!this.name) {
					this.requestSet.showToast('Please enter plant name');
					return;
				};
				var _imgObj = [],
					_imgList = this.imgArr;
				for (var i = 0; i < _imgList.length; i++) {
					_imgObj.push({
						url: _imgList[i],
						title: ""
					})
				};
				
				var datas = {
					common_name: this.searchName,
					member_id: this.userInfo.data.member_id,
					plant_name: this.name,
					plant_introduction: this.descripion,
					duration: this.duration,
					flower_color: this.color,
					fertilization: this.fertilization,
					water: this.water,
					exposure: this.exposure,
					soil: this.soil,
					minimum_tempature: this.minimum,
					blooming: this.blooming,
					update_time: "",
					img: this.imgArr.join(','),
				};
				var _url;
				if(this.param.id) {
					_url = '/V1.Garden/update'
					datas.id = this.param.id;
				} else {
					_url = '/V1.Garden/add'
				}
				uni.showLoading({
					mask: true,
					title: "Loading"
				})
				this.disabled = true;
				this.requestSet.getData(datas, _url, 'POST').then((res) => {
					if (res.status == 200) {
						uni.$emit('refreshCenter');
						this.requestSet.showToast('Success');
						setTimeout(() => {
							// uni.navigateBack({
							// 	delta: 1
							// })
							uni.redirectTo({
								url: "/pages/center/garden/garden"
							})
						}, 1000);

					} else {
						this.disabled = false;
						this.requestSet.showToast(res.msg);
					};
				}).catch((err) => {
					this.disabled = false;
				});
			},
			//图片上传成功
			upSuccess(e) {
				this.imgArr.push(e.data);
			},
			//删除图片
			remImg(e) {
				this.imgArr.splice(e, 1);
				// console.log(this.imgArr)
			},
			nav(url) {
				// if (!this.userInfo) return;
				uni.navigateTo({
					url: url
				})
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
	.list_box {
		background-color: #f6f7f9;
		overflow: hidden;
	}

	.search_btn {
		background: linear-gradient(to right, #48cfb0, #48d39d);
		width: 80rpx;
		line-height: 40rpx;
		border-radius: 20rpx;
		height: 40rpx;
	}
</style>
