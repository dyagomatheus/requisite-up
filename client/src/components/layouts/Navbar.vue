<template>
    <nav class="indigo darken-4">
        <div class="nav-wrapper container">
        <a :href="url" class="brand-logo">Requisit<strong>Up</strong></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
           <slot />
        </ul>
        </div>
    </nav>
</template>

<script>
export default {
  name: 'Navbar',
  props:['url'],
  data () {
    return {
      msg: 'Primeira Página'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
