<template>
    <el-container class="max-height">
      <el-header class="my-head-box">
        <el-row type="flex" class="max-height" justify="space-between">
            <el-col class="head-logo-box max-height">
                <div class="max-height"></div>
            </el-col>
            <el-col :span="2">
                <el-row class="max-height" type="flex" justify="center" align="middle">
                  <el-dropdown class="max-height">
                    <div class="max-height">
                      <div class="head-user-box max-height">
                        <a href="####">
                          <img v-bind:src="userImgPath" class="head-user-img el-dropdown-link ">
                        </a>
                      </div>
                    </div>
                    <el-dropdown-menu slot="dropdown">
                      <a href="#/user"><el-dropdown-item>个人中心</el-dropdown-item></a>
                      <a @click="signOut"><el-dropdown-item>退出登录</el-dropdown-item></a>
                    </el-dropdown-menu>
                  </el-dropdown>
                </el-row>
            </el-col>
        </el-row>
      </el-header>

      <el-container class="max-height">
        <el-aside class="max-height my-aside">
          <el-row class="tac max-height">
              <el-col :span="24" class="max-height">
                <el-menu
                  default-active="1"
                  class="max-height"
                  :router="true"
                  @open="handleOpen"
                  @close="handleClose">
                  <el-menu-item index="/card">
                    <i class="el-icon-menu"></i>
                    <span slot="title">卡牌大全</span>
                  </el-menu-item>
                  <el-menu-item index="/cardset">
                    <i class="el-icon-document"></i>
                    <span slot="title">我的套牌</span>
                  </el-menu-item>
                  <el-menu-item v-show="b_userinfo" index="/usermanage">
                    <i class="el-icon-setting"></i>
                    <span slot="title">管理员管理</span>
                  </el-menu-item>
                </el-menu>
              </el-col>
          </el-row>
        </el-aside>
        <el-main>
            <el-card class="box-card">
                <router-view v-on:listenTo="changImg"></router-view>
            </el-card>
        </el-main>
      </el-container>
    </el-container>
</template>
<script>
    export default {
        data() {
          return {
            b_userinfo: false,
            isCollapse: true,
            userImgPath: "",
          };
        },
        mounted() {
            this.getUserImg();
            this.getPermission()
        },
        methods: {
          handleOpen(key, keyPath) {
            console.log(key, keyPath);
          },
          getPermission(){
            this.$axios.get('/get/permission').then((response) => {
              console.log(response)
              if(response.data.data > 0){
                this.b_userinfo = true
              }else{
                this.b_userinfo = false
              }
            })
          },
          handleClose(key, keyPath) {
            console.log(key, keyPath);
          },
          getUserImg(){
            this.$axios.get('/userImg').then((response) => {
              this.userImgPath = response.data
            }).catch((error)=>{
              this.getDefaultImg()
            })
          },
          getDefaultImg(){
            this.$axios.get('/default/img').then((response) => {
              this.userImgPath = response.data.path;
            }).catch((error) =>{
              this.$message.error("出错了!")
            })
          },
          changImg(imgPath){
            this.userImgPath = imgPath
          },
          signOut(){
            console.log(1111)
            this.$axios.get('/signout').then((response) => {
              window.location.href = '/loginUser'
            })
          }
        }
    }
</script>
<style lang="scss" scoped="" type="text/css">
a{
  text-decoration:none;
}
$shadow-color:rgba(26, 26, 26, 0.1);
$aside-width:200px;
.max-height{
    height:100%;
}
.max-width{
  width: 100%;
}
.congested{
  @extend .max-height;
  @extend .max-width;
}
.my-aside{
    width: $aside-width !important;
}
.my-head-box{
    box-shadow: 0 1px 3px $shadow-color;
    margin-bottom: 10px;
    background-color: white;
    padding: 0;

    .head-logo-box{
        width: $aside-width;

    }
    .head-user-box{
        padding: 5px;
        background-color: white;
        box-sizing: border-box;
        border-style: solid;
        border-color: $shadow-color;
        height: 100%;
        border-width: 1px;
        border-radius: 4px;
      .head-user-img{
        width: auto;
        height: 100%;
      }
    }
}
</style>