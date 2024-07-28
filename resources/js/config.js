const config = {
    notificationTimer: 3000, 
    tiny_mce: {
        api_key: "cw2b5h08m56tofzikcrxps9lufci53ls315hmwvf1eje98bu",
        plugins: 'print preview paste importcss searchreplace autolink autosave save directionality ' +
            'code visualblocks visualchars fullscreen image link media template codesample table ' +
            'charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists wordcount ' +
            'textpattern noneditable help charmap  emoticons',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect ' +
            'formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  ' +
            'numlist bullist | image  |  forecolor backcolor removeformat | pagebreak | ' +
            'charmap emoticons | fullscreen  preview save print | insertfile media ' +
            'template link anchor codesample | ltr rtl'
    },
    languages: ['vi', 'en'],
    langOptions: {
        'vi': "Tiếng Việt",
        'en': "Tiếng Anh"
    },
    sub_pages: ['about', 'products', 'news', 'terms-and-cond']
}

export default config
