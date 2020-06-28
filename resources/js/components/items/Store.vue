<template>
  <div class="container-fluid">
      <div class="row">
          <div class="col bg-dark text-white">
              <a href="" class="navbar-brand">Items Store</a>
          </div>
      </div>
      <div class="row">
          <div class="col-3 bg-info p-2">
              <h4 class="text-white m-2">Categories</h4>
              <category-controls/>
          </div>
          <div class="col-9 bg-success p-2">
              <item-list/>
          </div>
      </div>
  </div>
</template>

<script>
import ItemList from "./ItemList";
import CategoryControls from "./CategoryControls"
export default {
components:{ItemList,CategoryControls}

}
</script>

<style>

</style>
