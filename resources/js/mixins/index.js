import Vue from 'vue'
import moment from 'moment'
/*
  THIS FUNCTION Will include globally,
  will overrided by other, if function name is same
*/

Vue.mixin({
  data() {
    return {
      pageState: null,
    }
  },
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
    kebabCaseToString(str) {
      let new_str = [];
      let str_arr = str.split('_')
      str_arr.forEach(function (v, k) {
        let str = v[0].toUpperCase() + v.slice(1);
        new_str.push(str)
      })

      return new_str.join(' ')
    },
    contactPhotoUrl(v) {
      var base_url = window.location.origin;
      return base_url + '/view_image/' + v
    },
    getTime() {
      var d = new Date();
      var n = d.getTime();
      return n;
    },
    getYearDiff(from, to) {
      console.log(from)
      console.log(to)
      var years = moment(to).diff(from, 'years');
      return years;
    },
    setAnchor(v) {
      window.location.hash = "#" + v

      //update view state only for need, reduce resource usage
      if (v == 'overview') {
        this.$store.commit('updateViewState')
      }

    },

    moneyFormat(num) {
      if (isNaN(num) == false) {
        return '$ ' + Number(Math.ceil(num)).toLocaleString();
      } else {
        return '-'
      }
    },
    castNum(num) {
      if (isNaN(num) == false && num != null) {
        return num;
      } else {
        return 0
      }
    },

    calculatePV(rate, nper, pmt) {
      console.log("Rate: " + rate)
      console.log("NPER: " + nper)
      console.log("pmt: " + pmt)
      if (rate == 0) {
        return pmt * nper
      } else {
        return (pmt / rate) * (1 - Math.pow(1 + rate, -nper));
      }

    },

    calculateFV(rate, period, pv) {
      let result = 0
      if (rate == 0) {
        result = pv
      } else {
        let pow_rate = Math.pow(1 + rate, period)
        result = pv * pow_rate
      }
      return Math.round(result)
    },
    collapseClick(event) {
      if ($(event.target).hasClass("fa-chevron-down")) {
        $(event.target)
          .addClass("fa-chevron-up")
          .removeClass("fa-chevron-down")
      } else {
        $(event.target)
          .addClass("fa-chevron-down")
          .removeClass("fa-chevron-up")
      }
    },
    capitalizeFirstLetter(str) {
      var str = str.replace(/_/g, " ")
      var parts = str.split(" "),
        len = parts.length,
        i,
        words = []
      for (i = 0; i < len; i++) {
        var part = parts[i]
        var first = part[0].toUpperCase()
        var rest = part.substring(1, part.length)
        var word = first + rest
        words.push(word)
      }
      words = words.join(" ")
      if (words == "Business Personal Guarantor Loan") {
        return "Business Personal / Guarantor Loan"
      }
      return words
    },
    countObjElement(tdata) {
      var counter = 0
      $.each(tdata, function (index, value) {
        $.each(value, function (index, v) {
          counter++
        })
        return false
      })
      return counter - 1
    },

  }
})