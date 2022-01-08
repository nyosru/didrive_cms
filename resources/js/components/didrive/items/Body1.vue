<template>
  <div class="card card-default">
    <div class="card-header">
      <h3 class="card-title">Module: items2</h3>

      <div class="card-tools">
        <span style="display: inline-block; float: right">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>

          <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button> -->
        </span>

        <span style="display: inline-block; float: right">
          <link-pages />
        </span>
      </div>
    </div>

    <div class="card-body" style="display: block">
      <div class="row">
        <div class="col-12 text-center">
          <items-filters />
        </div>
      </div>

      <div class="row">
        <div
          class="col-12"
          v-if="!items_cfg.no_add || (items_cfg.no_add && items_cfg.no_add != true)"
        >
          <items-form-add :cfg="items_cfg" :now_module="now_module" />
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <table class="table table-striped">
            <thead>
              <tr>
                <th></th>
                <template v-for="v in items_cfg.cfg" :key="v.mod">
                  <th v-if="v.name && v.name.length">
                    {{ v.name }}
                  </th>
                </template>
              </tr>
            </thead>

            <tbody>
              <template v-for="v in data_filtered" :key="v.id">
                <items-item :item="v" :cfg="items_cfg"></items-item>
              </template>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="card-footer" style="display: block">
      <span style="float: right">
        <link-pages />
      </span>
    </div>

    <div class="overlay" v-if="items_loading">
      <i class="fas fa-3x fa-sync-alt fa-spin"></i>
    </div>

  </div>
</template>

<script>


//../ModItemsFilters.vue
import itemsFilters from '../../comand/PagesComponent.vue';
import linkPages from "../../comand/PagesComponent.vue";
import itemsItem from "./Item1.vue";
import itemsFormAdd from "./formAdd.vue";
import datas from "./../../../modules/didrive_items/datas.ts";
import filterSettings from "./../../../modules/filterSettings.ts";

import { watchEffect } from "vue";
import { useRoute } from "vue-router";

export default {
  components: {
    itemsItem,
    itemsFormAdd,
    linkPages,
    itemsFilters,
  },

  setup(props) {
    console.log("mod items setup");

    const route = useRoute();
    const { loadData } = datas();

    watchEffect(() => {
      loadData(route.params.module);
    });

    const { loading, cfg, data_filtered } = datas();
    const { showStatusDelete } = filterSettings();

    return {
      items_cfg: cfg,
      data_filtered,
      items_loading: loading,
      showStatusDelete,
      now_module: route.params.module,
    };
  },
};
</script>
