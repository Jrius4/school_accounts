<template>
  <section class="mb-12 text-center">
    <h1
      :class="`font-weight-light mb-2 headline ${color}`"
      v-text="`${heading}`"

    />

    <span
      class="font-weight-light subtitle-1"
      v-if="subtitle!== ''"
    >
      {{subtitle}}
    </span>
  </section>
</template>

<script>
  export default {
    name: 'VComponent',

    props: {
      heading: {
        type: String,
        default: '',
      },
      subtitle: {
        type: String,
        default: '',
      },
      color: {
        type: String,
        default: '',
      },
      link: {
        type: String,
        default: '',
      },
    },
  }
</script>
