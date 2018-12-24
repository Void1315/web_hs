<template>
	<div>
		<h1>用户管理</h1>
	
		  <el-table
		    :data="userData"
		    stripe
		    style="width: 100%">
		    <el-table-column
		      prop="id"
		      label="id"
		      width="180">
		    </el-table-column>
		    <el-table-column
		      prop="name"
		      label="姓名"
		      width="180">
		    </el-table-column>
		    <el-table-column
		      prop="email"
		      label="email">
		    </el-table-column>
		    <el-table-column
		      prop="permission"
		      :formatter="permissionFormatter"
		      label="权限">
		    </el-table-column>
		    <el-table-column
		      prop="deleted_at"
		      label="状态">
		        <template slot-scope="scope">
			      <el-tag
			          :type="scope.row.deleted_at === '' ? 'success' : 'error'"
			          disable-transitions>{{statusFormatter(scope.row)}}
			      </el-tag>
		 	    </template>
		    </el-table-column>
		    <el-table-column label="操作">
		      <template slot-scope="scope">
		        <el-button
		          size="mini"
		          @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
		        <el-button
		          size="mini"
		          type="danger"
		          @click="handleDelete(scope.$index, scope.row)">{{scope.row.deleted_at == null?'封禁' : '解封'}}</el-button>
		      </template>
		    </el-table-column>
		  </el-table>


		 <el-dialog title="收货地址" :visible.sync="dialogFormVisible">
			<el-form :model="userForm">
				<el-form-item label="用户ID" :label-width="formLabelWidth">
				  <el-input v-model="userForm.id" :disabled="true" autocomplete="off"></el-input>
				</el-form-item>
				<el-form-item label="名称" :label-width="formLabelWidth">
				  <el-input v-model="userForm.name" autocomplete="off"></el-input>
				</el-form-item>
				<el-form-item label="用户权限" :label-width="formLabelWidth">
				  <el-select v-model="userForm.permission" placeholder="请选择权限">
				    <el-option label="用户" value="0"></el-option>
				    <el-option label="管理员" value="1"></el-option>
				    <el-option label="超级管理员" :disabled="true" value="2"></el-option>
				  </el-select>
				</el-form-item>
			</el-form>
			<div slot="footer" class="dialog-footer">
				<el-button @click="dialogFormVisible = false">取 消</el-button>
				<el-button type="primary" @click="updataUserInfo">确 定</el-button>
			</div>
		</el-dialog>

  </div>
</template>
<script type="text/javascript">
export default{
	data(){
		return{
			formLabelWidth:'120px',
			userData: [],
			dialogFormVisible:false,
			userForm:{
				id:'',
				name:'',
				permission:'',
			},
		}
	},
	mounted(){
		this.getUser();
	},
	methods:{
		getUser(){
			this.$axios.get('/get/user/info').then((response)=>{
				this.userData = response.data
			})
		},
		permissionFormatter(row, column) {
			if(row.permission == 0){
				return "用户"
			}else if(row.permission == 1){
				return "管理员"
			}else if(row.permission == 2){
				return "超级管理员"
			}
        	return row.permission;
        },
        statusFormatter(row){
        	if(row.deleted_at){
        		return "已封禁"
        	}else{
        		return "使用中"
        	}
        },
        handleEdit(index, row) {
        	this.userForm.id = row.id
        	this.userForm.name = row.name
        	this.userForm.permission = String(row.permission)
        	this.dialogFormVisible = true
	        console.log(index, row);
	    },
	    handleDelete(index, row) {
	    	if(row.deleted_at!=null){
	    		this.$confirm('此操作将解封该用户, 是否继续?', '提示', {
		          confirmButtonText: '确定',
		          cancelButtonText: '取消',
		          type: 'warning'
		        }).then((response) => {

		        	this.$axios.post('/unsealing/user',{
		        		id:row.id
	        		}).then((response)=>{
		        		this.$message({
				            type: 'success',
				            message: '解封成功!'
			          });
		        		row.deleted_at = null
		        	}).catch((error) => {
		        		this.$message.error("解封错误"+error)
		        	})
		        }).catch(() => {
		          this.$message({
		            type: 'info',
		            message: '取消'
		          });          
		        });

	    		return
	    	}
	        this.$confirm('此操作将封禁该用户, 是否继续?', '提示', {
	          confirmButtonText: '确定',
	          cancelButtonText: '取消',
	          type: 'warning'
	        }).then((response) => {

	        	this.$axios.post('/deleted/user',{
	        		id:row.id
        		}).then((response)=>{
	        		this.$message({
			            type: 'success',
			            message: '封禁成功!'
		          });
	        		row.deleted_at = 1
	        	}).catch((error) => {
	        		this.$message.error("封禁错误"+error)
	        	})
	          
	        }).catch(() => {
	          this.$message({
	            type: 'info',
	            message: '已取消封禁'
	          });          
	        });
	    },
	    updataUserInfo(){
	    	this.$axios.post('/updata/user/info',this.userForm
	    	).then((response) => {
	    		this.$message.success("修改成功!")
	    		this.dialogFormVisible = false
	    		this.getUser();
	    	}).catch((error) => {
	    		this.$message.error("修改错误"+error)
	    		console.log(error)
	    	})
	    },
	},
}	
</script>
<style lang="scss" scoped="" type="text/css">

</style>