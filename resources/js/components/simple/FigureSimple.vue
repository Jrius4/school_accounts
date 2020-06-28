<template>
  <div>
      <numbers/>
        <div class="my-3"></div>
      <subraction/>
        <div class="my-3"></div>
      <maths operation="Divide" firstVal="10" secondVal="50"/>
        <div class="my-3"></div>
      <maths operation="Multiply" firstVal="10" secondVal="50"/>

  </div>
</template>

<script>
import Subraction from "./Subraction";
import Numbers from "./Numbers";
export default {
components:{Subraction,Numbers}
}
</script>
