<template>
  <div id="app">
    <DemoVuetify></DemoVuetify>
  </div>
</template>

<script>

import DemoVuetify from './components/DemoVuetify.vue'

export default {
  name: 'App',
  components: {
    DemoVuetify
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
