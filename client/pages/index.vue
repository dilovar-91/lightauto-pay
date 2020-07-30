<template>
<div class="container">
    <el-form :model="form" :rules="rules" class="mt-0" ref="form">
    <div class="row">
    <div class="col-md-3 pr-2 pl-2  mb-2">    
    <el-form-item prop="transport" required>
    <el-select v-model="form.transport" size="large" class="w-100" clearable placeholder="Вид транспорта">
    <el-option
      v-for="item in option"
      :key="item.value"
      :label="item.label"
      :value="item.value">
    </el-option>
    </el-select>
    </el-form-item>
    </div>
    <div class="col-md-5 pr-2 pl-2  mb-2">
    <el-form-item prop="fio" required>
    <el-input
    placeholder="ФИО"
    v-model="form.fio">
    </el-input>
    </el-form-item>
  </div>
    <div class="col-md-4 pr-2 pl-2  mb-2">
    <el-form-item prop="phone" required>
    <el-input
    masked="true"
    v-model="form.phone"
    v-mask="'+7 (###) ###-## ##'"
    placeholder="+7 (___) ___-__ __"
    >
    </el-input>
    </el-form-item>
  </div>    
    <div class="col-md-12 pr-2 pl-2 mb-2">
    <el-form-item >    
     <Dropzone id="foo" ref="el" height="120px" :options="options" :destroyDropzone="true"></Dropzone>
    <div class="el-form-item__error" v-if ="form.image === ''">
          Заргужите рисунок чека
        </div>
    </el-form-item>
    </div>
    <div class="col-md-8 pr-2 pl-2 mb-2">    
      <el-button type="success" class="btn-block" style="background-color:#57b151; border-color:#57b151;" @click="addRequest()">Отправить</el-button>
    </div>
    <div class="col-md-4 pr-2 pl-2 mb-2">    
      <el-button type="danger" class="btn-block" @click="resetForm()">Сбросить</el-button>
    </div>
    </div>
  </el-form>
  </div>
</template>
<script>
import Dropzone from 'nuxt-dropzone'
import 'nuxt-dropzone/dropzone.css'
export default {
  'layout': 'main', 
  head () {
    return { title: this.$t('home') }
  },
  components: {
    Dropzone
  },
  data() {
    return {
      form: {
        transport: '',
        fio: '',
        phone: '',
        image: ''
      },
      options: {
        url: 'http://transit/api/uploadimage',
        autoProcessQueue: false,
        uploadMultiple: true,
        acceptedFiles: "image/*",
        maxFilesize: 2, // MB
        maxFiles: 4,
        dictDefaultMessage: "<i class='fa fa-camera fa-5x'></i>",
        addRemoveLinks: true,
        //headers: { "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content }
      },
       option: [{
          value: '1',
          label: 'ЖД'
        }, {
          value: '2',
          label: 'Авиа'
        }, {
          value: '3',
          label: 'Автобус'
        }, {
          value: '4',
          label: 'Автомобиль'
        }],
      rules: {
        fio: [
          {
            required: true,
            message: "Пожалуйста введите ФИО",
            trigger: "blur",
          },
          {
            min: 3,
            max: 45,
            message: "ФИО должен бить не менее 10 символов",
            trigger: "blur",
          },
        ],
        transport: [
            { required: true, message: 'Выберите вид транспорта', trigger: 'change' }
          ],
        phone: [
          {
            required: true,
            message: "Пожалуйста введите ваш телефон",
            trigger: "blur",
          },
          {
            min: 18,
            max: 18,
            message: "Вы ввели номер неправильно",
            trigger: "blur",
          },
        ],
      }
    }
  },   
  mounted() {
    const instance = this.$refs.el.dropzone
  },
  methods:{
      success(file, response) {
            this.form.image = response.imageName
        },
      removedImage(file, response) {
            this.form.image = ''
        },
      addRequest() {
      this.$refs["form"].validate((valid) => {
          if (!valid) {
            return false;
          }
          this.$axios
            .post("api/addrequest", { transport: this.form.transport, phone: this.form.phone, image: this.form.image })
            .then((response) => {
              if (response.status === 201) {
                this.show = false;
                this.$notify({
                  title: "Спасибо, заявка принята",
                  message: "Ожидайте в течении 10 минут оператор свяжется с Вами",
                  position: "top-right",
                  type: "success",
                  showClose: false,
                });
              }
            })
            .catch((error) => {
              this.$notify({
                title: "Извините" + this.form.phone,
                message: "Произошла ошибка!!!",
                position: "top-right",
                type: "error",
                showClose: false,
              });
            });
          this.show = false;
          this.$refs["form"].resetFields();  
        });
      },
      resetForm() {
        this.$refs["form"].resetFields();        
      },
  }

}
</script>
<style scoped>
@import url("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
</style>