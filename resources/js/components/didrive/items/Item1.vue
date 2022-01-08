<template>
  <tr>
    <td>
      <item-on-off v-if="cfg.status && cfg.status == true" :item="item"></item-on-off>
      <item-on-off-user
        v-if="cfg.status_user && cfg.status_user == true"
        :item="item"
      ></item-on-off-user>

      <small v-if="1 == 2">
        <br />
        <br />
        item: {{ item }}
        <br />
        <br />
        cfg: {{ cfg }}
      </small>
    </td>

    <template v-for="c in cfg.cfg" :key="c.mod">
      <td v-if="c.mod && c.mod.length && c.name && c.name.length">
        <show-data :pole="c" :val="item[c.mod]" />
      </td>
    </template>
  </tr>
</template>

<script>
import itemOnOff from "./Item1OnOff.vue";
import itemOnOffUser from "./Item1OnOffUser.vue";
import showData from "./ItemShowData.vue";

export default {
  props: {
    item: { type: Object },
    cfg: { type: Object },
  },

  //   data() {
  //     return {
  //     };
  //   },

  setup(
    props
    // context
  ) {
    return {};
  },

  components: {
    itemOnOff,
    itemOnOffUser,
    showData,
  },

};
</script>

<style></style>
