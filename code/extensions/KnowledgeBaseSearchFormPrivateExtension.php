<?php

class KnowledgeBaseSearchFormPrivateExtension extends DataExtension
{

    /**
     * Hook to allow us to update the {@link AutocompleteField} to ensure
     * private FAQs aren't visible.
     *
     * @param Form $form
     */
    public function updateForm($form)
    {
        $fields = $form->Fields();

        $queryField = $fields->dataFieldByName('Query');

        if ($queryField) {
            $queryField->setSuggestionData($this->filterSuggestionData());
        }
    }

    /**
     * Helper to ensure the suggestions displayed in the {@link KnowledgeBaseSearchForm}
     * filter the private questions appropriately.
     *
     * @return array
     */
    private function filterSuggestionData()
    {
        $faqs = FAQ::get();

        if (!Permission::check('FAQ_PRIVATE_QUESTIONS_ACCESS')) {
            $faqs = $faqs->filter('PrivateFAQ', false);
        }

        return $faqs->column('Question');
    }

}
