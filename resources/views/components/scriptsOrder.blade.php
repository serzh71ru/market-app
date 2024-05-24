<script>
    $("#address").suggestions({
        token: "b1fd6c9aee617244fe2e0e93a23ef9d28c72613d",
        type: "ADDRESS",
        onSelect: function(suggestion) {
        }
    });
</script>
<script>
    function toggleRequired(radio) {
      const addressInput = document.querySelector('#address');
      if (radio.checked && radio.classList.contains('toggl')) {
        addressInput.required = true;
      } else {
        addressInput.required = false;
      }
    }
</script>