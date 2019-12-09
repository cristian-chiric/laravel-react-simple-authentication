import { TextField } from "@material-ui/core";
import { withStyles } from '@material-ui/core/styles';

export const StyledTextField = withStyles({
    root: {
        width: '100%',
    }
})(TextField)
