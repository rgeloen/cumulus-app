const weatherToday = document.querySelector('.weather-today')
const weatherWeek = document.querySelector('.week-results')
const moreInfos = document.querySelector('.more-infos')

const todayButton = document.querySelector('.button-today')
const weekButton = document.querySelector('.button-week')
const infosButton = document.querySelector('.button-infos')


todayButton.addEventListener("click", (e) => {
  e.preventDefault()
  if (weatherWeek.classList.contains('active')) {
    todayButton.classList.add('active')
    weekButton.classList.remove('active')

    weatherWeek.classList.remove('active')
    weatherToday.classList.add('active')
  } else if (moreInfos.classList.contains('active')) {
      todayButton.classList.add('active')
      infosButton.classList.remove('active')

      moreInfos.classList.remove('active')
      weatherToday.classList.add('active')
    }
});


weekButton.addEventListener("click", (e) => {
  e.preventDefault()
  if (weatherToday.classList.contains('active')) {
    weekButton.classList.add('active')
    todayButton.classList.remove('active')

    weatherToday.classList.remove('active')
    weatherWeek.classList.add('active')
  } else if (moreInfos.classList.contains('active')) {
      weekButton.classList.add('active')
      infosButton.classList.remove('active')

      moreInfos.classList.remove('active')
      weatherWeek.classList.add('active')
    }
});


infosButton.addEventListener("click", (e) => {
  e.preventDefault()
  if (weatherToday.classList.contains('active')) {
    infosButton.classList.add('active')
    todayButton.classList.remove('active')

    weatherToday.classList.remove('active')
    moreInfos.classList.add('active')
  } else if (weatherWeek.classList.contains('active')) {
    infosButton.classList.add('active')
    weekButton.classList.remove('active')

    weatherWeek.classList.remove('active')
    moreInfos.classList.add('active')
  }
});
