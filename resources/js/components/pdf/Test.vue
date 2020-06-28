<template>
  <div>
    <!-- SOURCE -->
    <div id="printMe">
      <table class="table table-sm table-dark">
          <thead>
              <tr>
                  <th>
                      Name
                  </th>
                  <th>
                      Goals
                  </th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td rowspan="3">Kazibwe Julius Junior</td>
                  <td>Coding</td>
              </tr>
              <tr>
                  <td>Making Parents Happy</td>
              </tr>
              <tr>
                  <td>Being Rich</td>
              </tr>
          </tbody>
      </table>
    </div>
    <!-- OUTPUT -->
    <button class="btn btn-dark text-center" @click="print">Print</button>
  </div>
</template>

<script>
export default {
  data () {
    return {
      output: null
    }
  },
  methods: {
    print () {
      // Pass the element id here
      this.$htmlToPaper('printMe',null,()=>{
          console.log('printing is done')
      });
    }
  }
}
</script>
<style>

</style>
