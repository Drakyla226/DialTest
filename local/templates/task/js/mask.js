document.addEventListener('DOMContentLoaded', () => {
    const elements = document.querySelectorAll('[data-mask="phone"]') // ищем все поля с атрибутом data-mask="phone"
    if (!elements) return // если таких нет, прекращаем выполнение функции
    const phoneOptions = { // создаем объект параметров
      mask: '+{375}(00)000-00-00' // задаем единственный параметр mask
    }
    elements.forEach(el => { // для каждого найденного поля с атрибутом [data-mask="phone"]
      IMask(el, phoneOptions) // инициализируем плагин с установленными выше параметрами
    })
  })