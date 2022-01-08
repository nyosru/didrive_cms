<template>
  <div>
    <template v-if="pole.type && pole.type.length && pole.type == 'img'">
      <img v-if="val && val.length > 3" :src="pole.url_start + val" class="prev" />
      <span v-else> ... </span>
    </template>

    <template v-else>
      {{ val ?? "---" }}
    </template>
  </div>
</template>

<script>
export default {

  props: {
    pole: { type: Object },
    val: { type: String },
  },

  //   data() {
  //     return {};
  //   },

  setup(
    props
    // context
  ) {
    return {};
  },
};
</script>

<style>
.prev {
  max-height: 100px;
  max-width: 100px;
}
</style>
