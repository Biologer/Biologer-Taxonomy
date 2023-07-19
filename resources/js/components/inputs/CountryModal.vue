<template>
  <div class="modal-card">
    <div class="modal-card-head">
      <p class="modal-card-title">{{ trans('labels.countries.title') }}</p>
    </div>

    <div class="modal-card-body">
      <template v-if="processing">
        {{ trans('labels.countries.processing') }}

        <span class="loader mr-2 is-inline-block"></span>
      </template>

      <template v-else>
        <b-field>
          <b-radio
            v-for="country in countries"
            :key="country.id"
            v-model="country_id"
            :native-value="country.id"
            :disabled="isDisabled(country)"
          >
            {{ country.name }}
          </b-radio>
        </b-field>
      </template>
    </div>

    <div class="modal-card-foot" v-if="!processing">
      <button type="button" class="button is-primary" @click="addToCounty" :disabled='isBtnDisabled'>{{ trans('buttons.add_to_country') }}</button>

      <button type="button" class="button is-danger" @click="removeFromCounty" :disabled='isBtnDisabled'>{{ trans('buttons.remove_from_country') }}</button>

      <button type="button" class="button" @click="$emit('cancel')">{{ trans('buttons.cancel') }}</button>
    </div>
  </div>
</template>

<script>

export default {
  name: 'nzCountryModal',

  props: {
    checked: {
      type: Array,
      default: () => []
    },

    countries: {
      type: Array,
      default: () => []
    },

    filter: {
      type: Object,
      default: () => ({})
    },

    addurl: {
      type: String,
      required: true
    },

    removeurl: {
      type: String,
      required: true
    },

    country_id: {
      type: Number,
      required: true
    },

  },

  data() {
    return {
      processing: false,
    }
  },

  computed: {
    isBtnDisabled(){
      return this.country_id == null;
    }
  },

  methods: {
    addToCounty(){
      this.processing = true

      axios.post(this.addurl, {
        taxa_ids: this.checked,
        country_id: this.country_id
      }).then(this.successfullyAdded).catch(this.failed)

    },

    successfullyAdded() {
      this.processing = false
      this.country_id = null

      this.$buefy.toast.open({
        message: this.trans('Taxa have been added to selected country'),
        type: 'is-success'
      })

      this.$emit('done')
    },

    removeFromCounty(){
      this.processing = true

      axios.post(this.removeurl, {
        taxa_ids: this.checked,
        country_id: this.country_id
      }).then(this.successfullyRemoved).catch(this.failed)

    },

    successfullyRemoved() {
      this.processing = false
      this.country_id = null

      this.$buefy.toast.open({
        message: this.trans('Taxa have been removed from selected country'),
        type: 'is-success'
      })

      this.$emit('done')
    },

    failed(error) {
      this.processing = false
      this.country_id = null

      this.$buefy.toast.open({
        message: this.trans('There was some problem while adding/removing taxa from country'),
        type: 'is-danger',
        duration: 5000
      })
    },

    isDisabled(country){
      return country.active !== true;
    },
  },
}
</script>
