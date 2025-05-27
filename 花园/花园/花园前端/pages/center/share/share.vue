<template>
	<view>
		<markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer>
		<image src="../../../static/images/share.jpg" mode="widthFix" style="width: 100%;display: block;"></image>
		<view class="p0_30">
			<view class="bgf p30 bor20 flex">
				<view class="flex_1 tac" style="border-right: 2rpx solid #e0e8e0;">
					<view class="fz28 ca mb30">Invited today</view>
					<view class="fz32 ca fw9">{{userInfo.data.invite_today}}</view>
				</view>
				<view class="flex_1 tac">
					<view class="fz28 ca mb30">Cumulative invitation</view>
					<view class="fz32 ca fw9">{{userInfo.data.invite_total}}</view>
				</view>
			</view>
			<!--  -->
			<view class="fz60 ca lh100 tac fw9 mt20 mb20">Activity rules</view>
			<view class="bgf bor10 boxSha p20 fz24">
				<u-parse :html="info.share_body" :domain="$r.imgUrl"></u-parse>
			</view>
			<view class="h40"></view>
		</view>
		<view class="footer">
			<view class="h100"></view>
			<view class="share_btn boxSha bgf flex itc juc" @click="share">
				<view class="share fz30 cf tac">Invitation <code></code></view>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				param: {},
				timestamp: Date.parse(new Date()), //时间戳等于页面名称
				isMark: true, //是否显示页面遮罩 
				markType: 1,
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				info: {}
			}
		},
		onLoad() {
			this.getList();
		},
		methods: {
			getList() {
				var datas = {
					// apipage: "newslist",
					// keyword: this.param.keyword
				};
				this.requestSet.getData(datas, "/Config/list", 'GET').then((res) => {
					if (res.status == 200) {
						this.info = res.data;
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
			share() {
				uni.setClipboardData({
					data: 'http://gardenet.ebloomify.com/register/index.html?id=' + this.userInfo.data.invitation_code,
					success: () => {
						this.requestSet.showToast('Copy successfully, paste and share')
					},
					fail(err) {
						this.requestSet.showToast('Fail')
					}
				});
			}
		}
	}
</script>

<style>
	page {
		background: #e3fce9;
	}

	.share_btn {
		height: 100rpx;
		position: fixed;
		left: 0;
		bottom: 0;
		width: 100%;
	}

	.share {
		width: 600rpx;
		height: 70rpx;
		line-height: 70rpx;
		border-radius: 35rpx;
		background-color: #77e5c0;
	}
</style>
