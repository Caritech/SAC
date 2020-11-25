import Vue from 'vue'
import moment from 'moment'
/*
  THIS FUNCTION Will include globally,
  will overrided by other, if function name is same
*/

Vue.mixin({
  methods: {
    showLoading() {
      this.$store.commit('showLoading');
    },
    hideLoading() {
      this.$store.commit('hideLoading');
    },
    hideFullLoading() {
      this.$store.commit('hideFullLoading');
    },
    showFullLoading() {
      this.$store.commit('showFullLoading');
    },
    //use to disable global loading
    disableAxiosLoading() {
      this.$store.commit('disableLoading');
    },
    addTime(time, num, type = "hours") {
      return moment(time, "HH:mm:ss").add(num, type).format('HH:mm:ss');
    },
    filterObject(lists_to_search, column_to_search, value_to_search) {
      let filtered = lists_to_search.filter((value) => {
        if (value[column_to_search] == value_to_search) {
          return value;
        }
      });
      return filtered;
    },

    showInfo(title, body) {
      this.$swal({
        icon: 'info',
        title: title,
        html: body,
        showDenyButton: false,
        showCancelButton: false,
        confirmButtonText: `Ok`,
      }).then((result) => {
        //do nothing
      })
    },
    async showSuccess(title, body) {
      await this.$swal({
        icon: 'success',
        title: title,
        html: body,
        showDenyButton: false,
        showCancelButton: false,
        confirmButtonText: `Ok`,
      }).then((result) => {
        //do nothing
      })
    },
    async showConfirm(title, body, fn) {
      this.$swal({
        icon: 'info',
        title: title,
        text: body,
        showCancelButton: true,
      }).then((result) => {
        if (result.value) {
          fn();
        }
      });
    },
    show404Alert(url_to_redirect) {
      this.$swal({
        icon: 'error',
        title: '404 Not Found Error',
        showDenyButton: false,
        showCancelButton: false,
        confirmButtonText: `Back`,
      }).then((result) => {
        location.href = url_to_redirect
      })
    },
    toTime: function (value) {
      if (!value) return ""
      value = value.toString()
      return moment(value, "HH:mm:ss").format("hh:mm A")
    },
    toTimeShort: function (value) {
      if (!value) return ""
      value = value.toString()
      let str = moment(value, "HH:mm:ss").format("h:ma")
      str = str.slice(0, -1) //'abcde'
      return str
    },
    checkEmpty(val) {
      if (!val) {
        val = '-';
      }
      return val;
    },
    capitalize(str) {
      str = str[0].toUpperCase() + str.slice(1);
      return str
    },
    contactPhotoUrl(v) {
      var base_url = window.location.origin;
      return base_url + '/view_image/' + v
    },
    getTime() {
      var d = new Date();
      var n = d.getTime();
      return n;
    }
  }
})