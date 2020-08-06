<template>
  <div class="container">
    <el-form ref="form" :model="form" :rules="rules" class="mt-0" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-3 pr-2 pl-2 mb-2">
          <el-form-item prop="transport" required>
            <el-select
              v-model="form.transport"
              size="medium"
              class="w-100"
              clearable
              placeholder="ВИД ТРАНСПОРТА"
            >
              <el-option
                v-for="item in option"
                :key="item.value"
                :label="item.label"
                :value="item.label"
              />
            </el-select>
          </el-form-item>
        </div>
        <div class="col-md-5 pr-2 pl-2 mb-2">
          <el-form-item prop="fio" required>
            <el-input v-model="form.fio" size="medium" placeholder="ФИО" />
          </el-form-item>
        </div>
        <div class="col-md-4 pr-2 pl-2 mb-2">
          <el-form-item prop="phone" required>
            <el-input
              v-model="form.phone"
              v-mask="'+7 (###) ###-## ##'"
              size="medium"
              masked="true"
              placeholder="+7 (___) ___-__ __"
            />
          </el-form-item>
        </div>

        <div class="col-md-12 pr-2 pl-2 mb-2">
          <el-form-item>
            <el-upload
              ref="upload"
              list-type="picture-card"
              action="addrequest"
              name="file[]"
              :data="form"
              :on-success="handleSuccess"
              :on-remove="handleRemove"
              :on-change="handleChange"
              multiple
              :limit="3"
              :on-exceed="handleExceed"
              :file-list="fileList"
              :auto-upload="false"
            >
              <i slot="default" class="el-icon-plus" />
              <div slot="file" slot-scope="{file}">
                <img class="el-upload-list__item-thumbnail" :src="file.url" alt />
                <span class="el-upload-list__item-actions">
                  <span
                    class="el-upload-list__item-preview"
                    @click="handlePictureCardPreview(file)"
                  >
                    <i class="el-icon-zoom-in" />
                  </span>
                  <span
                    v-if="!disabled"
                    class="el-upload-list__item-delete"
                    @click="handleDownload(file)"
                  >
                    <i class="el-icon-download" />
                  </span>
                  <span
                    v-if="!disabled"
                    class="el-upload-list__item-delete"
                    @click="handleRemove(file)"
                  >
                    <i class="el-icon-delete" />
                  </span>
                </span>
              </div>
            </el-upload>
            <el-dialog :visible.sync="dialogVisible">
              <img width="100%" :src="dialogImageUrl" alt />
            </el-dialog>
            <div class="el-form-item">Фото чека</div>
          </el-form-item>
        </div>
        <div class="col-md-8 pr-2 pl-2 mb-2">
          <el-button
            type="success"
            class="btn-block"
            style="background-color:#57b151; border-color:#57b151;"
            @click="submitUpload"
          >Отправить</el-button>
        </div>
        <div class="col-md-4 pr-2 pl-2 mb-2">
          <el-button type="danger" class="btn-block" @click="resetForm()">Сбросить</el-button>
        </div>
      </div>
    </el-form>
  </div>
</template>
<script>
export default {
  layout: "main",
  head() {
    return { title: "Оплата проезда" };
  },
  data() {
    return {
      fileList: [],
      form: {
        transport: "",
        fio: "",
        phone: "",
        image: "",
        images: [],
      },

      dialogImageUrl: "",
      dialogVisible: false,
      disabled: false,
      imageMessage: false,

      option: [
        {
          value: "1",
          label: "ЖД",
        },
        {
          value: "2",
          label: "АВИА",
        },
        {
          value: "3",
          label: "АВТОБУС",
        },
        {
          value: "4",
          label: "АВТОМОБИЛЬ",
        },
      ],
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
          {
            required: true,
            message: "Выберите вид транспорта",
            trigger: "change",
          },
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
        file: [
          { required: true, message: "Загрузите фото чека", trigger: "change" },
        ],
      },
    };
  },
  mounted() {
    // const instance = this.$refs.myVueDropzone.dropzone
  },
  methods: {
    submitUpload() {
      this.$refs.form.validate((valid) => {
        if (valid) {
          const formData = new FormData();
          formData.append("fio", this.form.fio);
          formData.append("transport", this.form.transport);
          formData.append("phone", this.form.phone);

          for (let i = 0; i < this.form.images.length; i++) {
            formData.append("file[]", this.form.images[i]);
          }

          this.$axios
            .post("/addrequest", formData, {
              headers: {
                "Content-Type": "multipart/form-data",
              },
            })
            .then(() => {
              this.$notify({
                title: "Спасибо, заявка принята",
                message: "Ожидайте в течении 30 минут оператор свяжется с Вами",
                position: "bottom-right",
                type: "success",
                showClose: false,
              });
              this.$refs.form.resetFields();
              this.$refs.upload.clearFiles();
            })
            .catch((err) => {
              if (err) {
                this.$notify({
                  title: "Извините",
                  message: "Произошла ошибка, повторите ещё раз!!!",
                  position: "bottom-right",
                  type: "error",
                  showClose: false,
                });
              }
            });
        } else {
          return false;
        }
      });
    },
    handleRemove(file, fileList) {
      const vm = this;
      const index = _.findIndex(vm.fileList, ["uid", file.uid]);
      vm.$delete(vm.fileList, index);
    },
    handleSuccess(response, file, fileList) {
      const vm = this;
      _.map(response, function (data) {
        file.uid = data;
      });
      vm.fileList = fileList;
    },
    handleChange(file, fileList) {
      this.fileList = fileList;
      this.form.images = [];
      for (let i = 0; i < fileList.length; i++) {
        let obj = {};
        obj = fileList[i].raw;
        this.form.images.push(obj);
      }
    },
    handleExceed(files, fileList) {
      this.$notify({
        title: "Извините",
        message: "Загружать не более 4 файлов!!!",
        position: "bottom-right",
        type: "error",
        showClose: false,
      });
    },
    resetForm() {
      this.$refs.form.resetFields();
      this.$refs.upload.clearFiles();
    },
  },
};
</script>
