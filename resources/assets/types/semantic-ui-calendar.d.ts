/// <reference types="jquery"/>

interface SemanticUiCalendarOptions {
    type?: string;
}

interface JQuery {
    calendar(options?: SemanticUiCalendarOptions): JQuery;
}
