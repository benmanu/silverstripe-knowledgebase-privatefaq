<?php

class KnowledgebasePage_ControllerExtension extends DataExtension
{

    /**
     * Using this hook to update the {@link SearchQuery} to add a filter
     * field to check against private FAQs if the user is logged in.
     *
     * @param SearchQuery $query
     */
    public function updateSearchQuery($query)
    {
        // check that the user has valid permission to view private FAQs
        if (!Permission::check('FAQ_PRIVATE_QUESTIONS_ACCESS')) {

            // modify query with added 'private FAQ' filter
            $query->filter('FAQ_PrivateFAQ', 0);
        }
    }

    /**
     * Using this hook to prevent page being viewed if the user does not have
     * permission to view this {@link FAQ}.
     *
     * @param array $data
     *
     * @return null
     * @throws SS_HTTPResponse_Exception
     */
    public function onBeforeView($data)
    {
        $faq = array_key_exists('FAQ', $data) ? $data['FAQ'] : null;

        if ($faq && $faq->exists() && $faq->PrivateFAQ) {
            if (!Permission::check('FAQ_PRIVATE_QUESTIONS_ACCESS')) {
                return $this->owner->httpError(404);
            }
        }
    }

}
