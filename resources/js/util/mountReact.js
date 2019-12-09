import React from 'react'
import ReactDOM from 'react-dom'
import { MuiThemeProvider, createMuiTheme } from '@material-ui/core/styles'
import generatedTheme from '../theme'

const theme = createMuiTheme(generatedTheme);
/**
 * Used to mount a React component while spreading the mounts data attributes as props
 * @param {string} selector
 * @param {React Component} Component
 */
export function mountReact(selector, Component) {
  const element = document.getElementById(selector)
  if (!element) return

  const serverProps = { ...element.dataset }
  const props = {}
  Object.keys(serverProps).forEach(key => {
    if (serverProps[key] === '') return
    props[key] = JSON.parse(serverProps[key])
  })

    ReactDOM.render(<MuiThemeProvider theme = { theme }><Component {...props}/></MuiThemeProvider>, element)
}
