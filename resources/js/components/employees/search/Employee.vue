<template>
  <div class="card card-body p-0">
      <p class="card-text">
          {{employee.name}}
      </p>
  </div>
</template>

<script>
export default {
    props:['employee'],

}
</script>

<style scoped>
.card{
    cursor: pointer;
    margin-bottom: 2px;
}

</style>
