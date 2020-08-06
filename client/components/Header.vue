<template>
  <header>
    <div class="navbar navbar-dark box-shadow mb-4">
      <div class="container">
        <div class="col-md-4 text-md-left text-center">
          <a href="#" class="navbar-brand">
            <img height="60px" src="/logo.png" />
          </a>
        </div>
        <div class="col-md-8 text-md-left text-center">
          <span class="h2 font-weight-bold text-white">Оплата проезда</span>
        </div>
      </div>
    </div>
  </header>
</template>
<script>
export default {
  data() {
    return {
      activeIndex: "1",
      activeIndex2: "1",
    };
  },
  methods: {
    handleSelect(key, keyPath) {
      console.log(key, keyPath);
    },
  },
};
</script>
<style scoped>
@import url("https://use.typekit.net/oov2wcw.css");
.navbar {
  background: #fcdb00;
}

.h3 {
  font-family: "DejaVu Sans Condensed";
}
</style>