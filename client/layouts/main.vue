<template>
  <div>
    <div class="container-fluid pl-0 pr-0">
      <Header />
      <el-row>
        <nuxt />
      </el-row>
    </div>
  </div>
</template>

<script>
import Header from "~/components/Header";

export default {
  components: {
    Header,
  },
};
</script>
<style lang="scss" scoped>
.el-row {
  margin-bottom: 20px;
  &:last-child {
    margin-bottom: 0;
  }
}
</style>
