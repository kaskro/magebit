let field = Vue.component("field", {
  template: `
  <div class="form-field" v-on:click="setFocus" >
      <div class="form-field-top">
          <div class="form-field__input">
              <label :class="{ mini : isFocused }">{{ caption }}<span class="red">*</span></label>
              <input :id="id" :name="name" @focus="onFocus" @blur="onLoseFocus" ref="field" :type="type" v-model.lazy:value="value">
          </div>
          <div v-if="icon.length > 0" class="icon" :class="icon + (isActiveIcon ? '-active' : '-default')">&nbsp</div>
      </div>
      <hr />
      <div class="form-field__error" :class="{hide : !isError }">{{ error }}</div>
  </div>
  `,
  props: ["caption", "id", "name", "type", "icon", "error", "default"],
  data() {
    return {
      isFocused: this.default.length > 0,
      isActiveIcon: false,
      isError: this.error.length > 0,
      value: this.default,
    };
  },
  methods: {
    setFocus: function () {
      this.$refs.field.focus();
    },

    onFocus() {
      this.isFocused = true;
      this.isActiveIcon = true;
      this.isError = false;
    },

    onLoseFocus: function () {
      if (this.$refs.field.value == "" || this.$refs.field.value == null) {
        this.isFocused = false;
      }
      this.isActiveIcon = false;
      this.isError = false;
    },
  },
});

Vue.component("field-list", {
  template: `
  <ul class="attributes-list">
    <li v-for="(attribute, index) in attributes" :key="attribute.id">
      <div class="d-flex full m-r space-between">
        <div class="half">
          <field :caption="(attribute.name.length > 0 ) ? attribute.name + ' name' : 'Attribute' + (index + 1) + ' name'" :id="'attribute-name' + (index + 1)" :name="'attribute-name' + (index + 1)" type="text" icon="" error="" :default="attribute.name"></field>
        </div>
        <div class="half">
          <field :caption="(attribute.name.length > 0 ) ? attribute.name + ' value' : 'Attribute' + (index + 1) + ' value'" :id="'attribute-value' + (index + 1)" :name="'attribute-value' + (index + 1)" type="text" icon="" error="" :default="attribute.value"></field>
        </div>
      </div>
      <div class="icon delete-default" v-on:click="removeAttribute(index)">&nbsp</div>
    </li>
    <li><button id="addField" class="button gray" type="button" v-on:click="addAttribute">Add attribute</button></li>
  </ul>
  `,
  components: {
    field,
  },
  props: ["fields"],
  data() {
    return {
      id: JSON.parse(this.fields).length,
      attributes: JSON.parse(this.fields),
    };
  },
  methods: {
    addAttribute: function () {
      console.log(this.fields);
      this.attributes.push({
        id: this.id,
        name: "",
        value: "",
      });
      this.id++;
    },
    removeAttribute: function (id) {
      this.attributes.splice(id, 1);
    },
  },
});

new Vue({
  el: "#vue-container",
});

const slider = document.getElementById("slider");
const loginButton = document.getElementById("loginBtn");
const loginForm = document.getElementById("loginForm");
const loginInfo = document.getElementById("loginInfo");

const signupButton = document.getElementById("signupBtn");
const signupForm = document.getElementById("signupForm");
const signupInfo = document.getElementById("signupInfo");

// Slider events
// Slide to right covering login
if (slider) {
  loginButton.addEventListener("click", function () {
    slider.classList.remove("js_slide_left");
    slider.classList.add("js_slide_right");

    loginInfo.classList.add("fade-out");
    signupForm.classList.add("fade-out");

    slider.getElementsByClassName("back-fold-left")[0].classList.remove("hide");
    slider.getElementsByClassName("back-fold-right")[0].classList.add("hide");

    window.setTimeout(function () {
      loginForm.classList.remove("hide");
      signupForm.classList.add("hide");
      loginForm.classList.add("fade-in");
      loginInfo.classList.add("hide");

      signupInfo.classList.remove("hide");
      signupInfo.classList.add("fade-in");
    }, 250);
  });

  // Slide to left covering signup
  signupButton.addEventListener("click", function () {
    slider.classList.remove("js_slide_right");
    slider.classList.add("js_slide_left");

    signupInfo.classList.add("fade-out");

    loginForm.classList.add("fade-out");

    slider
      .getElementsByClassName("back-fold-right")[0]
      .classList.remove("hide");
    slider.getElementsByClassName("back-fold-left")[0].classList.add("hide");

    window.setTimeout(function () {
      signupForm.classList.remove("hide");
      loginForm.classList.add("hide");
      signupForm.classList.add("fade-in");
      signupInfo.classList.add("hide");

      loginInfo.classList.remove("hide");
      loginInfo.classList.add("fade-in");
    }, 250);
  });
}
