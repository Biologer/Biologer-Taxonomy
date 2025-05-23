<template>
  <form :action="action" method="POST" @submit.prevent="submitWithRedirect">
    <div>
      <b-field :label="trans('labels.countries.selected')">
        <div class="block">
          <b-checkbox
            v-for="country in countries"
            :key="country.id"
            v-model="form.countries_ids"
            :native-value="country.id"
            :disabled="isDisabled(country)"
          >
            {{ trans(`labels.countries.${country.code}`) }}
          </b-checkbox>
        </div>
      </b-field>
    </div>
    <hr>
    <div class="columns">
      <div class="column is-4">
        <nz-taxon-autocomplete
          :label="trans('labels.taxa.parent')"
          v-model="parentName"
          @select="onTaxonSelect"
          :error="form.errors.has('parent_id')"
          :message="form.errors.first('parent_id')"
          :taxon="taxon.parent || null"
          :except="taxon.id"
          :placeholder="trans('labels.taxa.search_for_taxon')"
          autofocus
        />
      </div>

      <div class="column is-5">
        <b-field
          :label="trans('labels.taxa.name')"
          class="is-required"
          :type="form.errors.has('name') ? 'is-danger' : ''"
          :message="form.errors.has('name') ? form.errors.first('name') : ''"
        >
          <b-input v-model.trim="sanitizedName"/>
        </b-field>
      </div>

      <div class="column is-3">
        <b-field
          :label="trans('labels.taxa.rank')"
          class="is-required"
          :type="form.errors.has('rank') ? 'is-danger' : ''"
          :message="form.errors.has('rank') ? form.errors.first('rank') : ''"
        >
          <b-select v-model="form.rank" expanded>
            <option
              v-for="(rank, index) in rankOptions"
              :value="rank.value"
              :key="index"
              v-text="rank.label"
            />
          </b-select>
        </b-field>
      </div>
    </div>

    <b-field
      :label="trans('labels.taxa.author')"
      :type="form.errors.has('author') ? 'is-danger' : ''"
      :message="form.errors.has('author') ? form.errors.first('author') : ''"
    >
      <b-input v-model="form.author" />
    </b-field>

    <hr>

    <b-field :label="trans('labels.taxa.native_name')">
      <b-tabs size="is-small" class="block" @change="(index) => focusOnTranslation(index, 'native_name')">
        <b-tab-item :label="trans('languages.' + data.name)" v-for="(data, locale) in supportedLocales" :key="locale">
          <b-input v-model="form.native_name[locale]" :ref="`native_name-${locale}`" />
        </b-tab-item>
      </b-tabs>
    </b-field>

    <b-field :label="trans('labels.taxa.description')">
      <b-tabs size="is-small" class="block" @change="(index) => focusOnTranslation(index, 'description')">
        <b-tab-item :label="trans('languages.' + data.name)" v-for="(data, locale) in supportedLocales" :key="locale">
          <nz-wysiwyg v-model="form.description[locale]" :ref="`description-${locale}`" />
        </b-tab-item>
      </b-tabs>
    </b-field>

    <hr>

    <div class="columns">
      <div class="column is-half">
        <b-field
          :label="trans('labels.taxa.fe_old_id')"
          :type="form.errors.has('fe_old_id') ? 'is-danger' : ''"
          :message="form.errors.has('fe_old_id') ? form.errors.first('fe_old_id') : ''"
        >
          <b-input v-model="form.fe_old_id" />
        </b-field>
      </div>

      <div class="column is-half">
        <b-field
          :label="trans('labels.taxa.fe_id')"
          :type="form.errors.has('fe_id') ? 'is-danger' : ''"
          :message="form.errors.has('fe_id') ? form.errors.first('fe_id') : ''"
        >
          <b-input v-model="form.fe_id" />
        </b-field>
      </div>
    </div>

    <div class="columns">
      <div class="column"></div>
      <div class="column">
        <b-field :label="trans('labels.taxa.restricted')">
        </b-field>
      </div>
      <div class="column">
        <b-field :label="trans('labels.taxa.allochthonous')">
        </b-field>
      </div>
      <div class="column">
        <b-field :label="trans('labels.taxa.invasive')">
        </b-field>
      </div>
    </div>

    <div v-if="countries.filter(c => form.countries_ids.includes(c.id)).length === 0" class="field">
      {{ trans('labels.taxa.please_select_country') }}
    </div>

    <div class="columns" v-else>
      <div class="column">
        <div v-for="country in countries.filter(c => form.countries_ids.includes(c.id))" :key="country.id">
          <b-field :label="trans(`labels.countries.${country.code}`)">
          </b-field>
        </div>
      </div>
      <div class="column">
        <div v-for="country in countries.filter(c => form.countries_ids.includes(c.id))" :key="country.id">
          <b-switch v-model="form.countries[country.id].restricted">
            {{ form.countries[country.id].restricted ? trans('Yes') : trans('No') }}
          </b-switch>
        </div>
      </div>

      <div class="column">
        <div v-for="country in countries.filter(c => form.countries_ids.includes(c.id))" :key="country.id">
          <b-switch v-model="form.countries[country.id].allochthonous">
            {{ form.countries[country.id].allochthonous ? trans('Yes') : trans('No') }}
          </b-switch>
        </div>
      </div>

      <div class="column">
        <div v-for="country in countries.filter(c => form.countries_ids.includes(c.id))" :key="country.id">
          <b-switch v-model="form.countries[country.id].invasive">
            {{ form.countries[country.id].invasive ? trans('Yes') : trans('No') }}
          </b-switch>
        </div>
      </div>
    </div>

    <b-field :label="trans('labels.taxa.stages')" v-if="stages.length">
      <div class="block">
        <b-checkbox
          v-for="stage in stages"
          :key="stage.id"
          v-model="form.stages_ids"
          :native-value="stage.id"
        >
          {{ trans('stages.' + stage.name) }}
        </b-checkbox>
      </div>
    </b-field>

    <b-field :label="trans('labels.taxa.conservation_legislations')" v-if="conservationLegislations.length">
      <div class="block">
        <div class="columns is-multiline is-gapless">
          <div class="column is-half" v-for="conservationLegislation in conservationLegislations" :key="conservationLegislation.id">
            <b-tooltip :label="conservationLegislation.description" multilined>
              <b-checkbox
                v-model="form.conservation_legislations_ids"
                :native-value="conservationLegislation.id"
              >
                {{ conservationLegislation.name }}
              </b-checkbox>
            </b-tooltip>
          </div>
        </div>
      </div>
    </b-field>

    <b-field :label="trans('labels.taxa.conservation_documents')" v-if="conservationDocuments.length">
      <div class="block">
        <div class="columns is-multiline is-gapless">
          <div class="column is-half" v-for="conservationDocument in conservationDocuments" :key="conservationDocument.id">
            <b-tooltip :label="conservationDocument.description" multilined>
              <b-checkbox
                v-model="form.conservation_documents_ids"
                :native-value="conservationDocument.id"
              >
                {{ conservationDocument.name }}
              </b-checkbox>
            </b-tooltip>
          </div>
        </div>
      </div>
    </b-field>

    <div class="field" v-if="redLists.length">
      <label class="label">{{ trans('labels.taxa.red_lists') }}</label>

      <b-field v-for="(addedRedList, index) in form.red_lists_data" :key="index" grouped>
        <div class="control is-expanded">
          <span v-text="getRedListName(addedRedList.red_list_id)"></span>
        </div>

        <b-select v-model="addedRedList.category">
          <option v-for="category in redListCategories" :value="category" :key="category" v-text="category">
          </option>
        </b-select>

        <div class="control">
          <button type="button" class="button has-text-danger" @click="removeRedList(index)">&times;</button>
        </div>
      </b-field>

      <b-field grouped v-if="availableRedLists.length">
        <b-select v-model="chosenRedList" expanded>
          <option v-for="option in availableRedLists" :value="option" :key="option.id" v-text="option.name">
          </option>
        </b-select>

        <div class="control">
          <button type="button" class="button" @click="addRedList">{{ trans('labels.taxa.add_red_list') }}</button>
        </div>
      </b-field>
    </div>

    <b-field :label="trans('labels.taxa.atlas_codes')">
      <b-checkbox v-model="form.uses_atlas_codes">
        {{ trans('labels.taxa.uses_atlas_codes') }}
      </b-checkbox>
    </b-field>

    <hr>

    <b-field
      :label="trans('labels.taxa.synonyms')"
      :type="form.errors.has('synonyms') ? 'is-danger' : null"
      :message="form.errors.has('synonyms') ? form.errors.first('synonyms') : null"
      :addons="false"
    >
      <b-field
        v-for="(_,i) in synonyms"
        :key="i"
        expanded
        :addons="false"
      >
        <b-field
          expanded
        >
          <b-input
            :name="`synonyms[${i}][name]`"
            v-model="form.synonyms[i].name"
            :placeholder="trans('labels.taxa.synonym_name')"
            expanded
          />

          <b-input
            :name="`synonyms[${i}][author]`"
            v-model="form.synonyms[i].author"
            :placeholder="trans('labels.taxa.synonym_author')"
            expanded
          />

          <p class="control">
            <button type="button" class="button is-danger is-outlined" @click="removeSynonym(i)">
              <b-icon icon="times" size="is-small"/>
            </button>
          </p>

        </b-field>
      </b-field>

      <b-field
        :type="synonym_error ? 'is-danger' : null"
        :message="synonym_error ? trans(synonym_error) : null"
      >

        <b-input id="synonym_name" maxlength="50" v-model="synonym_name"
                 :placeholder="trans('labels.taxa.synonym_name')"
                 expanded
                 v-on:keydown.native.enter.prevent="addSynonym"
        />
        <b-input id="synonym_author" maxlength="50" v-model="synonym_author"
                 :placeholder="trans('labels.taxa.synonym_author')"
                 expanded
                 v-on:keydown.native.enter.prevent="addSynonym"
        />

        <p class="control">
          <button type="button" class="button is-secondary is-outlined" @click="addSynonym">
            {{ trans('labels.taxa.add_synonym') }}
          </button>
        </p>
      </b-field>
    </b-field>

    <hr>

    <button
      type="submit"
      class="button is-primary"
      :class="{
          'is-loading': form.processing
      }"
      @click="submitWithRedirect"
    >
      {{ trans('buttons.save') }}
    </button>

    <a :href="cancelUrl" class="button is-text" @click="onCancel">{{ trans('buttons.cancel') }}</a>
  </form>
</template>

<script>
import Form from 'form-backend-validation'
import _keys from 'lodash/keys'
import _find from 'lodash/find'
import _first from 'lodash/first'
import _get from 'lodash/get'
import FormMixin from '@/mixins/FormMixin'
import NzWysiwyg from '@/components/inputs/Wysiwyg'
import NzTaxonAutocomplete from '@/components/inputs/TaxonAutocomplete'

function defaultTranslations() {
  const value = {}

  _keys(window.App.supportedLocales).forEach(locale => {
    value[locale] = null
  })

  return value
}

export default {
  name: 'nzTaxonForm',

  mixins: [FormMixin],

  components: {
    NzWysiwyg,
    NzTaxonAutocomplete
  },

  props: {
    taxon: {
      type: Object,
      default() {
        return {
          name: null,
          parent_id: null,
          rank: 'species',
          rank_level: 10,
          author: null,
          fe_id: null,
          fe_old_id: null,
          conservation_legislations: [],
          conservation_documents: [],
          red_lists: [],
          stages: [],
          restricted: false,
          allochthonous: false,
          invasive: false,
          uses_atlas_codes: false,
          synonyms: [],
          countries: [],
        }
      }
    },
    ranks: Array,
    conservationLegislations: Array,
    conservationDocuments: Array,
    redListCategories: Array,
    redLists: {
      type: Array,
      default() { return [] }
    },
    stages: Array,
    nativeNames: {
      type: Object,
      default: () => defaultTranslations()
    },
    descriptions: {
      type: Object,
      default: () => defaultTranslations()
    },
    countries: Array,
    removedSynonyms: {
      type: Array,
      default: () => []
    },
  },

  data() {
    return {
      form: this.newForm(),
      parentName: _get(this.taxon, 'parent.name'),
      selectedParent: null,
      chosenRedList: null,
      synonym_name: null,
      synonym_author: null,
      synonym_error: null,
      synonyms: this.taxon.synonyms,
      restrictedSwitch: 0,
      componentKey: 0,
    }
  },

  computed: {
    rankOptions() {
      if (this.selectedParent) {
        return this.ranks.filter((rank) => rank.level < this.selectedParent.rank_level)
      }

      return this.ranks
    },

    availableRedLists() {
      const addedRedListIds = this.form.red_lists_data

      return this.redLists.filter(redList => !_find(addedRedListIds, rl => redList.id == rl.red_list_id))
    },

    supportedLocales() {
      return window.App.supportedLocales
    },

    sanitizedName: {
      get() {
        return this.form.name || '';
      },
      set(value) {
        const sanitized = value.replace(/\s+/g, ' ').trim();
        if (this.form.name !== sanitized) {
          this.form.name = sanitized;
        }
      }
    },

    booleanRestricted: {
      get() {
        return Boolean(this.form.countries[country.id]?.restricted);
      },
      set(value) {
        this.$set(this.form.countries[country.id], 'restricted', value ? 1 : 0);
      }
    },

    booleanInvasive: {
      get() {
        return Boolean(this.form.countries[country.id]?.invasive);
      },
      set(value) {
        this.$set(this.form.countries[country.id], 'invasive', value ? 1 : 0);
      }
    },

    booleanAllochthon: {
      get() {
        return Boolean(this.form.countries[country.id]?.allochthon);
      },
      set(value) {
        this.$set(this.form.countries[country.id], 'allochthon', value ? 1 : 0);
      }
    },
  },

  watch: {
    selectedParent(value) {
      if (this.shouldResetRank(value)) {
        this.form.rank = null
      }
    },

    'form.name': {
      handler(value) {
        if (value) {
          const sanitized = value.replace(/\s+/g, ' ').trim();
          if (value !== sanitized) {
            this.form.name = sanitized;
          }
        }
      },
      immediate: true
    },

    'form.countries_ids': {
      handler(newVal) {
        newVal.forEach(id => {
          const country = this.taxon.countries.find(c => c.id === parseInt(id));

          if (!this.form.countries[id]) {
            let restrictedValue = this.taxon.restricted ?? false;
            let allochthonousValue = this.taxon.allochthonous ?? false;
            let invasiveValue = this.taxon.invasive ?? false;

            if (country && country.pivot) {
              restrictedValue = country.pivot.restricted;
              allochthonousValue = country.pivot.allochthonous;
              invasiveValue = country.pivot.invasive;
            }

            this.$set(this.form.countries, id, {
              restricted: restrictedValue,
              allochthonous: allochthonousValue,
              invasive: invasiveValue
            });
            this.refreshComponent();
          }
        });

        Object.keys(this.form.countries).forEach(id => {
          if (!newVal.includes(parseInt(id))) {
            this.$delete(this.form.countries, id);
            this.refreshComponent();
          }
        });
      },
      immediate: true
    }
  },

  methods: {
    newForm() {
      return new Form({
        ...this.taxon,
        stages_ids: this.taxon.stages.map(stage => stage.id),
        conservation_legislations_ids: this.taxon.conservation_legislations.map(conservationLegislation => conservationLegislation.id),
        conservation_documents_ids: this.taxon.conservation_documents.map(conservationDocument => conservationDocument.id),
        countries_ids: this.taxon.countries.map(country => country.id),
        countries: this.initializeCountryValues(),
        red_lists_data: this.taxon.red_lists.map(redList => {
          return { red_list_id: redList.id, category: redList.pivot.category }
        }),
        native_name: this.nativeNames,
        description: this.descriptions,
        reason: null,
        uses_atlas_codes: this.taxon.uses_atlas_codes,
        synonyms: this.taxon.synonyms,
        removed_synonyms: this.removedSynonyms,
      }, {
        resetOnSuccess: false
      })
    },

    initializeCountryValues() {
      let countryData = {};

      this.countries.forEach(country => {
        const taxonCountry = this.taxon.countries.find(c => c.id === country.id);

        countryData[country.id] = {
          restricted: taxonCountry?.pivot?.restricted ?? this.taxon.restricted,
          allochthonous: taxonCountry?.pivot?.allochthonous ?? this.taxon.allochthonous,
          invasive: taxonCountry?.pivot?.invasive ?? this.taxon.invasive,
        };
      });

      return countryData;
    },

    refreshComponent() {
      this.componentKey++;
    },

    /**
     * Add synonym for taxon
     *
     */
    addSynonym() {
      let pass = true;
      if (this.synonym_name) {
        this.form.synonyms.forEach((item, index) => {
          if (this.synonym_name === item.name) {
            pass = false;
            this.synonym_error = "labels.observations.duplicate_value";
            this.$forceUpdate();
          }
        });

        if (pass) {
          this.form.synonyms.push({name: this.synonym_name, author: this.synonym_author});
          this.synonym_name = null;
          this.synonym_author = null;
          this.synonym_error = null;
        }
      } else {
        this.synonym_error = "labels.observations.field_is_required";
        this.$forceUpdate();
      }
    },

    /**
     * Remove synonym for taxon
     * @param index
     */
    removeSynonym(index) {
      this.removedSynonyms.push(this.synonyms[index]);
      this.$delete(this.synonyms, index);
    },

    /**
     * Add field to the form.
     */
    addRedList() {
      if (!this.chosenRedList) return

      this.form.red_lists_data.push({
        red_list_id: this.chosenRedList.id,
        category: _first(this.redListCategories)
      })

      this.chosenRedList = null
    },

    /**
     * Don't use the field any more.
     *
     * @param  {Object} field
     */
    removeRedList(index) {
      this.form.red_lists_data.splice(index, 1)
    },

    getRedListName(id) {
      return _find(this.redLists, { id }).name
    },

    /**
     * Handle taxon being selected.
     *
     * @param {Object} taxon
     */
    onTaxonSelect(taxon) {
      this.selectedParent = taxon
      this.form.parent_id = taxon ? taxon.id : null

      // Inherit parent's stages
      if (taxon && taxon.stages.length) {
        this.form.stages_ids = taxon.stages.map(stage => stage.id)
      }
    },

    shouldResetRank(selectedParent) {
      return selectedParent && this.getRankLevel(this.form.rank) >= selectedParent.rank_level
    },

    /**
     * Get rank level.
     * @param {Object} rank
     * @return {Number}
     */
    getRankLevel(rank) {
      return _get(_find(this.ranks, { value: rank }), 'level')
    },

    focusOnTranslation(index, attribute) {
      const locales = _keys(this.supportedLocales)
      const selector = `${attribute}-${locales[index]}`

      setTimeout(() => {
        _first(this.$refs[selector]).focus()
      }, 500)
    },

    isDisabled(country){
      return country.active !== true;
    }

  },
  loadSynonyms: function() {
    if (!this.taxon.synonyms) return [];
    let names = [];
    this.taxon.synonyms.forEach(item => names.push(item.name));
    return names;
  }
}
</script>
