<template>
	<view>
		<web-view :src="url"></web-view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				param:{},
				url:""
			}
		},
		onLoad(option) {
			console.log(option);
			if(option.shopType == 1) {
				this.url = 'https://dou.symhw.net/app/index.php?i=4&c=entry&m=ewei_shopv2&do=mobile&userPhone=' + this.userInfo.member.UserAccount;
			}
		},
		methods: {
			
		}
	}
</script>

<style>

</style>
