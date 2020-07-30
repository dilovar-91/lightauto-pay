<template>
<header>      
      <div class="navbar navbar-dark bg-dark box-shadow mb-4">
        <div class="container d-flex justify-content-between">
          <div class="col-md-3">
          <a href="#" class="navbar-brand d-flex align-items-center">
            <img height="70px" src="/main-logo.png" />
            
          </a>
          </div>
          <div class="col-md-8">
          <span class="text-white h3 text-center ml-5">Оплата проезда</span>
          </div>
          <!--
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>--->
          
        </div>
      </div>
    </header>

</template>

<script>
  export default {
    data() {
      return {
        activeIndex: '1',
        activeIndex2: '1'
      };
    },
    methods: {
      handleSelect(key, keyPath) {
        console.log(key, keyPath);
      }
    }
  }
</script>
<style scoped>
@import url("https://use.typekit.net/oov2wcw.css");
.bg-dark {
    background-color: #212425 !important;
}


.h3{
  font-family: century-gothic, sans-serif;
}
</style>