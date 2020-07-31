<template>
<div class="container">
    <el-form :model="form" :rules="rules" class="mt-0" ref="form" enctype="multipart/form-data">
    <div class="row">
    <div class="col-md-3 pr-2 pl-2  mb-2">    
    <el-form-item prop="transport" required>
    <el-select v-model="form.transport" size="medium" class="w-100" clearable placeholder="ВИД ТРАНСПОРТА">
    <el-option
      v-for="item in option"
      :key="item.value"
      :label="item.label"
      :value="item.label">
    </el-option>
    </el-select>
    </el-form-item>
    </div>
    <div class="col-md-5 pr-2 pl-2  mb-2">
    <el-form-item prop="fio" required>
    <el-input
    size="medium"
    placeholder="ФИО"
    v-model="form.fio">
    </el-input>
    </el-form-item>
  </div>
    <div class="col-md-4 pr-2 pl-2  mb-2">
    <el-form-item prop="phone" required>
    <el-input
    size="medium"
    masked="true"
    v-model="form.phone"
    v-mask="'+7 (###) ###-## ##'"
    placeholder="+7 (___) ___-__ __"
    >
    </el-input>
    </el-form-item>
  </div>    
    <div class="col-md-12 pr-2 pl-2 mb-2">      
    <el-form-item>
    <el-upload
  action="#"
  :file-list="fileList"
  list-type="picture-card"
  :http-request="handleDownload"  
  ref="upload"  
  
  :data="form"
  :before-upload="handleBeforeUpload"
  :auto-upload="false">
    <i slot="default" class="el-icon-plus"></i>
    <div slot="file" slot-scope="{file}">
      <img
        class="el-upload-list__item-thumbnail"
        :src="file.url" alt=""
      >
      <span class="el-upload-list__item-actions">
        <span
          class="el-upload-list__item-preview"
          @click="handlePictureCardPreview(file)"
        >
          <i class="el-icon-zoom-in"></i>
        </span>
        <span
          v-if="!disabled"
          class="el-upload-list__item-delete"
          @click="handleDownload(file)"
        >
          <i class="el-icon-download"></i>
        </span>
        <span
          v-if="!disabled"
          class="el-upload-list__item-delete"
          @click="handleRemove(file)"
        >
          <i class="el-icon-delete"></i>
        </span>
      </span>
    </div>
</el-upload>
<el-dialog :visible.sync="dialogVisible">
  <img width="100%" :src="dialogImageUrl" alt="">
</el-dialog>
    <div class="el-form-item__error" v-if="form.imageMessage">
          Загрузите фото чека
    </div>
    <div class="el-form-item__error text-muted" v-if="!form.imageMessage">
          Фото чека
    </div>
    </el-form-item>
    </div>
    <div class="col-md-8 pr-2 pl-2 mb-2">    
      <el-button type="success" class="btn-block" @click="submitUpload"  style="background-color:#57b151; border-color:#57b151;" >Отправить</el-button>
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
    return { title: 'Оплата проезда' }
  },
  components: {
    Dropzone
  },
  data() {
    return {
      fileList: [],
      form: {
        transport: '',
        fio: '',
        phone: '',
        image: ''
      },
     
      dialogImageUrl: '',
      dialogVisible: false,
      disabled: false,
      imageMessage: false,
      
       option: [{
          value: '1',
          label: 'ЖД'
        }, {
          value: '2',
          label: 'АВИА'
        }, {
          value: '3',
          label: 'АВТОБУС'
        }, {
          value: '4',
          label: 'АВТОМОБИЛЬ'
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
    //const instance = this.$refs.myVueDropzone.dropzone
  },
  methods:{      
      handleRemove(file) {
        console.log(file);
      },
      handlePictureCardPreview(file) {
        this.dialogImageUrl = file.url;
        this.dialogVisible = true;
      },

      submitUpload() {
        this.$refs.upload.submit();
      },
     
    handleBeforeUpload(file) {
      const allowedCsvMime = [
        'image/*',        
      ];
      if (allowedCsvMime.includes(file.type)) {
        return true;
      } else {
         this.$notify({
                title: "Ошибка",
                message: "Загрузите только фото",
                position: "bottom-right",
                type: "error",
                showClose: false,
              });        
        this.fileList.pop(file);
      }
    },
      handleDownload() {
       const formData = new FormData();
      formData.append('fio', this.form.fio);
      formData.append('transport', this.form.transport);
      formData.append('phone', this.form.phone);
      formData.append('file', this.file);
      console.log(this.file)
      console.log(formData.fileList)
      this.$axios
        .post('/addrequest', formData,  {headers: {'Authorization' : 'Bearer ' + localStorage.getItem('token') ,'Content-Type': 'multipart/form-data'}})
        .then(() => {
          this.$notify({
                  title: "Спасибо, заявка принята",
                  message: "Ожидайте в течении 30 минут оператор свяжется с Вами",
                  position: "bottom-right",
                  type: "success",
                  showClose: false,
                });
                this.$refs["form"].resetFields();
        })
        .catch((err) => {
          this.$notify({
                title: "Извините",
                message: "Произошла ошибка, повторите ещё раз!!!" + err,
                position: "bottom-right",
                type: "error",
                showClose: false,
              });
        });
      }
  }

}
</script>
<style scoped>
@import url("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
</style>