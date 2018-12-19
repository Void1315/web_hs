<template>
	<div class="container">
		<el-row>
			<el-col :span="12" :offset="6" class="user-head-box">
				<el-row>
					<el-col class="backimg-box">

						<div class="user-img-box">
							<img v-bind:src="userImgPath" class="user-img">
						</div>
					</el-col>
				</el-row>
				<el-row class="user-bottom-box">
					<el-col :offset="7">
						<span>
							<b>
								{{ form.name }}
							</b>
						</span>
						<div class="chang-img-box">
							<el-upload
							  action="/upload/img"
							  name="img"
							  :data="imgData"
							  :on-preview="handlePreview"
							  :on-remove="handleRemove"
							  :before-remove="beforeRemove"
							  :multiple = "false"
							  :show-file-list = "false"
							  :on-success="onSuccess"
							  :on-exceed="handleExceed"
							  :file-list="fileList">
								<el-button icon="el-icon-plus" plain>上传头像</el-button>
							</el-upload>
						</div>
					</el-col>
					<el-col :offset="7">
						<span>
							{{ form.email }}
						</span>
					</el-col>
				</el-row>
				<el-row>
					<el-card class="user-info-card">
					  	<el-form ref="form" :model="form" label-width="80px">
							  <el-form-item label="用户名">
							    <el-input 
							    v-model="form.name"></el-input>
							  </el-form-item>
							  <el-form-item label="邮箱">
							    <el-input 
							    v-model="form.email"
							    :disabled="true"
							    ></el-input>
							  </el-form-item>
							  <el-form-item>
							    <el-button type="primary" @click="onSubmit">立即更新</el-button>
							    
							  </el-form-item>
							</el-form>
  					</el-card>
				</el-row>
			</el-col>
		</el-row>
	</div>
</template>
<script>
export default {
    data() {
		return {
			userImgPath: "",
			fileList: [],
			imgData:{
				'_token':document.getElementsByTagName('meta')['csrf-token'].content,
			},
			form: {
	          name: '',
	          email: '',
	        },
		};
    },
    mounted() {
        this.getUserInfo();
    },
    methods: {
    	getUserInfo(){
    		this.$axios.get('/userInfo').then((response) =>{
    			this.userImgPath = response.data[0].image.path
    			this.form.name = response.data[0].name
    			this.form.email = response.data[0].email
    			// console.log(response.data[0].name)
    		}).catch((error) => {

    		})
    	},
    	handleRemove(file, fileList) {
        	console.log(file, fileList);
	    },
	    handlePreview(file) {
	        console.log(file);
	    },
	    handleExceed(files, fileList) {
	        this.$message.warning(`当前限制选择 3 个文件，本次选择了 ${files.length} 个文件，共选择了 ${files.length + fileList.length} 个文件`);
	    },
	    beforeRemove(file, fileList) {
	        return this.$confirm(`确定移除 ${ file.name }？`);
	    },
	    onSuccess(response, file, fileList){
	    	// this.userImgPath = response.data
	    	this.$message({
	          message: '上传成功！',
	          type: 'success'
	        });
	    	this.userImgPath = response
	    	this.$emit("listenTo",this.userImgPath)
	    },
	    onSubmit() {
        	this.$axios.post('/change/info',this.form).then((response) => {
        		this.$message({
		          message: '修改成功',
		          type: 'success'
		        });
        	}).catch((error) => {
        		this.$message({
		          message: '修改失败!'+error,
		          type: 'error'
		        });
        	})
      	}
    }
}
</script>
<style lang="scss" scoped="" type="text/css">
.user-head-box{
	.backimg-box{
		height: 132px;
		background-image: url("/image/back.jpg");
	    background-position: center;
	    background-repeat: no-repeat;
	    background-size: cover;
	    .user-img-box{
	    	display: inline-block;
		    height: 100%;
		    position: relative;
		    top: 60px;
		    left: 15px;
		    box-sizing: border-box;
		    padding: 5px;
		    background-color: white;
		    border-style: solid;
		    border-color: gainsboro;
		    border-width: 1px;
		    border-radius: 5px;
	    	.user-img{
	    		height: 100%;
	    		width: auto;
	    	}

	    }
	}
	.user-bottom-box{
		height: 116px;
	}
	.chang-img-box{
		display: inline-block;
    	margin-top: 19px;
	}
}
</style>